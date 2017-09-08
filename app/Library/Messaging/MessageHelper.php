<?php namespace FTX\Library\Messaging;

/**
 * Class MessageHelper
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 */

use Mail;
use Illuminate\Mail\Mailer;
use FTX\Models\Access\User\User;
use FTX\Repositories\Client\Signage\SignageConfig\EloquentSignageConfigRepository;

class MessageHelper extends Mailer
{
    /**
     * Email List
     *
     * @var
     */
    public $emailList;

    /**
     * Email Content
     *
     * @var
     */
    public $emailContent = [];

    /**
     * Construct
     *
     * @param bool|false $account
     */
    public function __construct($account = false)
    {
        $this->userModel        = new User();
        $this->configRepository = new EloquentSignageConfigRepository();

        if($account)
        {
            $this->getConfigUserEmails($account);
        }
    }

    /**
     * Get Configuration Email List
     *
     * @param $account
     * @return bool|void
     */
    public function getConfigUserEmails($account)
    {
        $this->emailList = $this->configRepository->getConfigurationEmails($account);
        return $this->emailList;
    }

    /**
     * Set Email List With User ID Array
     *
     * @param $users
     */
    public function setEmailListWithUsersByID($users)
    {
        $emailList = [];

        if(!empty($users) && count($users) > 0)
        {
            foreach($users as $user)
            {
                $model = $this->userModel->findOrFail($user);

                if(isset($model->email) && $model->email != '')
                {
                    $emailList[] = $model->email;
                }
            }
        }

        $this->emailList = $emailList;
    }

    /**
     * Add Custom Emails by Comma Separated List
     *
     * @param $emails
     */
    public function addCustomEmailsByCSV($emails)
    {
        $emails = explode(',', $emails);

        if(!empty($emails) && count($emails) > 0)
        {
            foreach($emails as $email)
            {
                $this->emailList[] = $email;
            }
        }
    }

    /**
     * Get Email View
     *
     * @param $view
     * @param $params
     * @return bool
     */
    public function getEmailView($view, $params)
    {
        if(view()->exists($view))
        {
            return view($view)->with($params)->render();
        }

        return false;
    }

    /**
     * Add Custom Row
     *
     * @param $params
     * @return bool
     */
    public function addCustomRow($params)
    {
        $data = [
            'message' => (isset($params['message']) ? $params['message'] : false)
        ];

        $this->emailContent[] = $this->getEmailView('emails.base.partials.custom-row', $data);
    }

    /**
     * Add Single Row
     *
     * @param $params
     */
    public function addSingleRowWithTitle($params)
    {
        $data = [
            'title'     => (isset($params['title']) ? $params['title'] : false),
            'message'   => (isset($params['message']) ? $params['message'] : false)
        ];

        $this->emailContent[] = $this->getEmailView('emails.base.partials.single-row', $data);
    }

    /**
     * Add 2 Column Row
     *
     * @param $params
     */
    public function addTwoColumnRow($params)
    {
        $data = [
            'left' => [
                'title'     => (isset($params['left']['title']) ? $params['left']['title'] : false),
                'message'   => (isset($params['left']['message']) ? $params['left']['message'] : false)
            ],
            'right' => [
                'title'     => (isset($params['right']['title']) ? $params['right']['title'] : false),
                'message'   => (isset($params['right']['message']) ? $params['right']['message'] : false)
            ]
        ];

        $this->emailContent[] = $this->getEmailView('emails.base.partials.2-column', $data);
    }

    /**
     * Add 2 Column Row
     *
     * @param $params
     */
    public function addTwoColumnBackgroundRow($params)
    {
        $data = [
            'left' => [
                'title'     => (isset($params['left']['title']) ? $params['left']['title'] : false),
                'message'   => (isset($params['left']['message']) ? $params['left']['message'] : false)
            ],
            'right' => [
                'title'     => (isset($params['right']['title']) ? $params['right']['title'] : false),
                'message'   => (isset($params['right']['message']) ? $params['right']['message'] : false)
            ]
        ];

        $this->emailContent[] = $this->getEmailView('emails.base.partials.2-column-bg', $data);
    }

    /**
     * Add Centered Button
     *
     * @param $params
     */
    public function addCenteredButton($params)
    {
        $data = [
            'button' => [
                'link'  => (isset($params['link']) ? $params['link'] : false),
                'text'  => (isset($params['text']) ? $params['text'] : false)
            ]
        ];

        $this->emailContent[] = $this->getEmailView('emails.base.partials.centered-button', $data);
    }

    /**
     * Get Email Output
     *
     * @return string
     */
    public function getBodyOutput()
    {
        $html = '';

        if($this->emailContent && !empty($this->emailContent))
        {
            foreach($this->emailContent as $contentSection)
            {
                $html .= $contentSection;
            }
        }

        return $html;
    }

    /**
     * Add Divider Row
     *
     */
    public function addDividerRow()
    {
        $this->emailContent[] = $this->getEmailView('emails.base.partials.divider', []);
    }

    /**
     * Send Message To User
     *
     * @param $user
     * @param $emailDetails
     * @param mixed $body
     * @param bool $debug
     */
    public function sendMessageToUser($user, $emailDetails, $body = false, $debug = false)
    {
        $output = ($body ? $body : $this->getBodyOutput());

        if($debug)
        {
            echo view('emails.base.email-wrapper')->with(['emailBody' => $output])->render();
            dd();
        }

        Mail::send('emails.base.email-wrapper', array('emailBody' => $output), function($message) use ($emailDetails, $user)
        {
            if($this->checkIsEmailAddress($user))
            {
                return $message->to($user, 'ControlCenter')->subject($emailDetails['subject']);
            }

            return $message->to($user->email, 'ControlCenter')->subject($emailDetails['subject']);
        });
    }

    /**
     * Send Message To Custom Email
     *
     * @param $emails
     * @param $emailDetails
     * @param mixed $body
     * @param bool $debug
     */
    public function sendMessageToCustomEmails($emails, $emailDetails, $body = false, $debug = false)
    {
        $output = ($body ? $body : $this->getBodyOutput());

        if($debug)
        {
            echo view('emails.base.email-wrapper')->with(['emailBody' => $output])->render();
            dd();
        }

        Mail::send('emails.base.email-wrapper', array('emailBody' => $output), function($message) use ($emailDetails, $emails)
        {
            return $message->to($emails, 'ControlCenter')->subject($emailDetails['subject']);
        });
    }

    /**
     * Send Message to List
     *
     * @param $emailDetails
     * @param mixed $body
     * @param bool $debug
     */
    public function sendMessageToList($emailDetails, $body = false, $debug = false)
    {
        $output = ($body ? $body : $this->getBodyOutput());

        if($debug)
        {
            echo view('emails.base.email-wrapper')->with(['emailBody' => $output])->render();
            dd();
        }

        if($this->emailList)
        {
            $this->emailList = array_filter($this->emailList);

            Mail::send('emails.base.email-wrapper', array('emailBody' => $output), function($message) use ($emailDetails)
            {
                $message->to($this->emailList, 'ControlCenter')->subject($emailDetails['subject']);
            });
        }
    }

    /**
     * Check is Email Address
     *
     * @param $string
     * @return bool
     */
    public function checkIsEmailAddress($string)
    {
        if(filter_var($string, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}