<?php 
namespace jrmadsen67\MahanaMailinatorTest;

use PHPUnit_Framework_TestCase;
use jrmadsen67\MahanaMailinatorAPI\MahanaMailinatorAPI;

class MahanaMailinatorTest extends PHPUnit_Framework_TestCase
{


    private $mailinatorAPI;

    private $inbox;


    public function __construct($mailinatorAPI)
    {
        $this->mailinatorAPI = $mailinatorAPI; 
    }
    

    // api calls

    public function setInbox($inbox)
    {
        $this->inbox = $inbox;
    }    

    public function cleanMessages($inbox)
    {
        $messages = $this->mailinatorAPI->fetchInbox($inbox);

        if (!empty($messages))
        {
            foreach ($messages as $message) {
                $this->mailinatorAPI->deleteMail($message['id']);
            }
        }    
    }

    public function getLastMessage($inbox)
    {
        $messages = $this->getMessages($inbox);
        if (empty($messages)) {
            $this->fail("No messages received");
        }
        // messages are in ascending order
        return end($messages);
    }

    public function getSingleMessage($msgId)
    {
        return $this->mailinatorAPI->fetchMail($msgId);
    }    

    public function getMessages($inbox)
    {
        return $this->mailinatorAPI->fetchInbox($inbox);
    }




    // assertions
    public function assertEmailIsSent($inbox, $description = '')
    {
        $this->assertNotEmpty($this->getMessages($inbox), $description);
    }
    
    public function assertEmailSubjectContains($needle, $email, $description = '')
    {
        $this->assertContains($needle, $email['subject'], $description);
    }

    public function assertEmailSubjectEquals($expected, $email, $description = '')
    {
        $this->assertContains($expected, $email['subject'], $description);
    }

    public function assertEmailHtmlContains($needle, $email, $description = '')
    {      
        $this->assertContains($needle, $email['parts'][1]['body'], $description);
    }

    public function assertEmailTextContains($needle, $email, $description = '')
    {
        $this->assertContains($needle, $email['parts'][0]['body'], $description);
    }

    public function assertEmailSenderNameEquals($expected, $email, $description = '')
    {
        $this->assertEquals($expected, $email['from'], $description);
    }

    public function assertEmailSenderEmailEquals($expected, $email, $description = '')
    {
        $this->assertEquals($expected, $email['fromfull'], $description);
    }

    public function assertEmailRecipientsContain($needle, $email, $description = '')
    {
        $this->assertContains($needle, $email['to'], $description);
    }

}    