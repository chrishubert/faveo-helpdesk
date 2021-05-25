<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;

/**
 * CreateTicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CreateTicketRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function wantsJson()
    {
        return in_array('api', $this->segments());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $check = $this->check(new CommonSettings());
        if ($check != 0)
            return $check;

        if ($this->route()->getName() == 'apiv1helpdeskcreate_qisqus')
            return $this->rulesQiscus();

        return [
            'email' => 'required|email|max:60',
            'first_name' => 'required|min:3|max:40',
            'helptopic' => 'required',
            // 'dept' => 'required',
            'sla' => 'required',
            'subject' => 'required|min:5',
            'body' => 'required|min:10',
            'priority' => 'required',
        ];
    }

    /**
     * @param object $settings (instance of Model common settings)
     *
     * @return array|int
     * @author manish.verma@ladybirdweb.com
     *
     * @category Function to set rule if send opt is enabled
     *
     */
    public function check($settings)
    {
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
        // dd($settings->status, $email_mandatory->status);

        if (($settings->status == '1' || $settings->status == 1) && ($email_mandatory->status == '1' || $email_mandatory->status == 1)) {
            return [
                'email' => 'required|email|max:60',
                'first_name' => 'required|min:3|max:40',
                'helptopic' => 'required',
                // 'dept' => 'required',
                'sla' => 'required',
                'subject' => 'required|min:5',
                'body' => 'required|min:10',
                'priority' => 'required',
                'code' => 'required',
                'mobile' => 'required',
            ];
        } elseif (($settings->status == '0' || $settings->status == 0) && ($email_mandatory->status == '1' || $email_mandatory->status == 1)) {
            return 0;
        } elseif (($settings->status == '0' || $settings->status == 0) && ($email_mandatory->status == '0' || $email_mandatory->status == 0)) {
            return $this->onlyMobleRequired();
        } elseif (($settings->status == '1' || $settings->status == 1) && ($email_mandatory->status == '0' || $email_mandatory->status == 0)) {
            return $this->onlyMobleRequired();
        } else {
            return 0;
        }
    }

    /**
     * @param null
     *
     * @return array
     * @category function to make only moble required rule
     *
     */
    public function onlyMobleRequired()
    {
        return [
            'email' => 'email|max:60',
            'first_name' => 'required|min:3|max:40',
            'helptopic' => 'required',
            // 'dept' => 'required',
            'sla' => 'required',
            'subject' => 'required|min:5',
            'body' => 'required|min:10',
            'priority' => 'required',
            'code' => 'required',
            'mobile' => 'required',
        ];
    }

    /**
     * @param null
     *
     * @return array
     * @category function to make only Qiscus Rules
     *
     */
    public function rulesQiscus()
    {
        return [
            'helptopic' => 'required', // id of the  assigned Help topic
            'dept' => 'required', // id of the department
            'sla' => 'required', // id of the sla
            'priority' => 'required', // id of the priority
        ];
    }
}
