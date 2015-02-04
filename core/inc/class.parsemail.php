<?php
/**
 * Class for parsing raw emails
 *
 * This class is used to parse raw emails into
 * logical easy to use parts.
 *
 * @author Joshua Gilman
 * @package Parser
 */
class Parser {
    /**
     * Determines how a newline is parsed
     *
     * @var String
     */
    var $P_NEWLINE = "\r\n";
    /**
     * Contains the raw header of the email
     *
     * @var String
     */
    var $header = NULL;
    /**
     * Contains the boundary used to parse the raw email
     *
     * @var String
     */
    var $boundary = NULL;
    /**
     * Contains everything below the header of the raw email
     *
     * @var String
     */
    var $content = NULL;
    /**
     * Contains who the email is addressed to
     *
     * @var String
     */
    var $to = NULL;
    /**
     * Contains who the email is from
     *
     * @var String
     */
    var $from = NULL;
    /**
     * Contains the subject of the email
     *
     * @var String
     */
    var $subject = NULL;
    var $spam = NULL;
    var $returnpath = NULL;
    var $autosubmitted = NULL;
    var $importance = NULL;
    var $priority = NULL;
    /**
     * Contains all the types of messages sent
     *
     * @example
     * <code>
     * $parser->message['plain'] // Returns the plain text message
     * $parser->message['htmk'] // Returns the html formatted message
     * </code>
     *
     * @var Mixed
     */
    var $message = array();
    /**
     * Contains all the parsed attachments in the raw email
     *
     * @var Mixed
     */
    var $files = array();
    /**
     * The constructor of the class
     *
     * This function loads and parses the raw email given ($mail)
     * and prepares it for usage
     *
     * @param String $mail
     * @return void
     */
    function __construct($mail) {
        if (empty($mail)) {
            throw new Exception("Invalid email argument; Email cannot be empty");
        }
        // Load everything up //
        $this->load_parts($mail);
        $this->load_contents();
        $this->load_message();
        $this->load_files();
    }
    /**
     * Sets up the class for other functions
     *
     * This function parses the boundary of the raw email
     * then preceeds to parse the header and content of
     * the raw email for other functions to use
     *
     * @param String $content
     * @return void
     */
    function load_parts($content) {
        if ($istart = strpos($content, "Content-Type:")) {
            if ($istart = strpos($content, "boundary=\"", $istart)) {
                $istart+= strlen("boundary=\"");
                $iend = strpos($content, "\"", $istart);
                $this->boundary = substr($content, $istart, $iend-$istart);
            }
        }
        if (!$this->boundary) {
            $this->boundary = "\r\n";
        }
        $parts = split($this->boundary, $content);
        $contents = split("\n\n", $content);
        unset($contents[0]);
        $this->plain = implode("\n", $contents);
        $header1 = array_shift($parts);
        $header2 = array_shift($parts);
        $this->header = $header1 . $header2;
        $this->content = implode($parts, $this->boundary);
    }
    /**
     * Parses the basic content of the email
     *
     * This function parses the to, from, and subject
     * from the raw email's header
     *
     * @return void
     */
    function load_contents() {
        if (preg_match("/To: (.*)/", $this->header, $match)) {
            $this->to = $match[1];
            if (preg_match("/.*<(.*)>/", $this->to, $match)) {
                $this->to = $match[1];
            }
        }
        if (preg_match("/From: (.*)/", $this->header, $match)) {
            $this->from = $match[1];
        }
        if (preg_match("/Subject: (.*)/", $this->header, $match)) {
            $this->subject = $match[1];
        }
        if (preg_match("/X-Spam-Flag: (.*)/", $this->header, $match)) {
            $this->spam = $match[1];
        }
        if (preg_match("/Return-Path: (.*)/", $this->header, $match)) {
            $this->returnpath = $match[1];
        }
        if (preg_match("/Auto-Submitted: (.*)/", $this->header, $match)) {
            $this->autosubmitted = $match[1];
        }
        if (preg_match("/Importance: (.*)/", $this->header, $match)) {
            $this->importance = $match[1];
        }
        if (preg_match("/Importance: (.*)/", $this->header, $match)) {
            $this->importance = $match[1];
        }
        if (preg_match("/X-Priority: (.*)/", $this->header, $match)) {
            $this->priority = $match[1];
        }
    }
    /**
     * Parses the message from the email
     *
     * This function parses the two common formats of
     * a raw message, plain text, and html formatted.
     * It loads both (if either one exists) into an
     * associative array based on their names
     *
     * @return void
     */
    function load_message() {
        $body = explode("--" . $this->boundary, $this->content);
        array_pop($body);
        $i = 0;
        foreach($body as $type) {
            if (stristr($type, "Content-Type: multipart/alternative;")) {
                $pattern = "/boundary\s*=\s*[\"|'](.*)[\"|']/";
                preg_match($pattern, $type, $matches);
                $multiboundary = $matches[1];
                $multibody = explode("--" . $multiboundary, $body[$i]);
                array_pop($multibody);
                unset($multibody[0]);
                $mi = 1;
                foreach($multibody as $mtype) {
                    if (stristr($mtype, "Content-Type: text/html;")) {
                        $html = $mi;
                    } elseif (stristr($mtype, "Content-Type: text/plain;")) {
                        $text = $mi;
                    }
                    $mi++;
                }
            } elseif (stristr($type, "Content-Type: text/html;")) {
                $html = $i;
            } elseif (stristr($type, "Content-Type: text/plain;")) {
                $text = $i;
            }
            $i++;
        }
        if ($mi > 1) {
            $htmlbody = explode("\n", $multibody[$html]);
            $textbody = explode("\n", $multibody[$text]);
            foreach($htmlbody as $line) {
                $content = stripos($line, "Content-");
                if ($content !== 0) {
                    $message['html'][] = $line;
                }
                unset($content);
            }
            foreach($textbody as $line) {
                $content = stripos($line, "Content-");
                if ($content !== 0) {
                    $message['text'][] = $line;
                }
                unset($content);
            }
            array_pop($message['html']);
            array_pop($message['text']);
            $this->message['html'] = implode("\n", $message['html']);
            $this->message['plain'] = implode("\n", $message['text']);
        } else {
            $htmlbody = explode("\n", $body[$html]);
            $textbody = explode("\n", $body[$text]);
            foreach($htmlbody as $line) {
                $content = stripos($line, "Content-");
                if ($content !== 0) {
                    $message['html'][] = $line;
                }
                unset($content);
            }
            foreach($textbody as $line) {
                $content = stripos($line, "Content-");
                if ($content !== 0) {
                    $message['text'][] = $line;
                }
                unset($content);
            }
            array_pop($message['html']);
            array_pop($message['text']);
            $this->message['html'] = implode("\n", $message['html']);
            $this->message['plain'] = implode("\n", $message['text']);
        }
    }
    /**
     * Parses any attachments in the raw email
     *
     * This function parses ALL attachments in
     * the email into an array of associative arrays
     * containing the common information of each
     * file including the name, base name, extension,
     * and content. The files contents are decoded
     * when they are parsed.
     *
     * @return void
     */
    function load_files() {
        $body = explode("--" . $this->boundary, $this->content);
        unset($body[0]);
        array_pop($body);
        $i = 0;
        foreach($body as $content) {
            $pattern = "/filename=(.*)/";
            preg_match($pattern, $content, $matches);
            $this->files[$i]['name'] = str_replace('"', '', $matches[1]);
            $parts = explode(".", $this->files[$i]['name']);
            $this->files[$i]['base_name'] = array_shift($parts);
            $ext = implode(".", $parts);
            $first = strpos($ext, ";");
            if ($first) {
                $this->files[$i]['ext'] = substr($ext, 0, $first);
            } else {
                $this->files[$i]['ext'] = $ext;
            }
            $filepos = explode("\n", $content);
            unset($filepos[0]);
            $f = 1;
            foreach($filepos as $file) {
                echo "File[$f]: $file\n";
                if (strlen($file) == "0") {
                    if ($u > 1) {
                        unset($filepos[$f]);
                    } else {
                        $u = 1;
                        while ($u <= $f) {
                            unset($filepos[$u]);
                            $u++;
                        }
                    }
                }
                $f++;
            }
            unset($u, $f);
            $file = implode("", $filepos);
            $this->files[$i]['content'] = base64_decode($file);
            $i++;
        }
    }
}
?>