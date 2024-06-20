<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'hardianto@kemdikbud.go.id';
    public string $fromName   = 'hardianto@kemdikbud.go.id';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */


    /**
     * SMTP Username
     */


    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    public int $wrapChars = 76;

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    // public bool $DSN = true;
    // public $SMTPHost = 'smtp.office365.com';
    // public $SMTPUser = 'no-reply_tppk@outlook.co.id';
    // public $SMTPPass = 'fD$xtYHktU4._xJ';
    // public $SMTPPort = 587;
    // public $SMTPCrypto = 'tls';
    // public $protocol = 'smtp';
    // public $mailPath = '/usr/sbin/sendmail';
    // public $mailType = 'html';
    // public $charset = 'utf-8';
    // public $wordWrap = true;
    // public $newline = "\r\n";
    // public $CRLF = "\r\n";
    // public $SMTPValidateCert = false;

    public bool $DSN = true;
    public $SMTPHost = 'mail.kemdikbud.go.id';
    public $SMTPUser = 'hardianto@kemdikbud.go.id';
    public $SMTPPass = 'lrzfolnif99';
    public $SMTPPort = 465;
    public $SMTPCrypto = 'ssl';
    public $protocol = 'smtp';
    public $mailPath = '/usr/sbin/sendmail';
    public $mailType = 'html';
    public $charset = 'utf-8';
    public $wordWrap = true;
    public $newline = "\r\n";
    public $CRLF = "\r\n";
    public $SMTPValidateCert = false;
}
