<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\gii\Contact;


/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['body', 'required'],  // TODO: how to force gii to set different type when regenerate?
            ['body', 'string', 'min' => 3, 'max' => 200],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact()
    {
        if ($this->validate()) {
            // Get email from config ... its test value -> normally we should iterate and find all by rbac here...

            $websiteEmail = Yii::$app->params['websiteEmail'];
            $websiteName = Yii::$app->params['websiteName'];

            // Sent Mail 2.
            Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['adminEmail']) // TODO: ??
                ->setFrom([$websiteEmail => $websiteName])
                ->setSubject("Pojawił się nowy kontakt. Zaloguj się, aby przeczytać") // TODO: templates for mails?
                ->setTextBody("Pojawił się nowy kontakt. Zaloguj się, aby przeczytać") // TODO: templates for mails?
                ->send();

            // Sent Mail 1.
            Yii::$app->mailer->compose()
                ->setTo(Yii::$app->user->identity->email)
                ->setFrom([$websiteEmail => $websiteName])
                ->setSubject("Formularz został dostarczony do BOK") // TODO: templates for mails?
                ->setTextBody("Formularz został dostarczony do BOK") // TODO: templates for mails?
                ->send();

            // Save data to database..
            $contact = new Contact();
            // TODO: here should be some time of create... but its not specified in task...
            $contact->message = $this->body;
            $contact->user_id = Yii::$app->user->identity->getId();
            $contact->save();

            return true;
        } else {
            return false;
        }
    }
}
