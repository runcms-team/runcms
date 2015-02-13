<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: propritary
*
*/

if (!defined("ERCX_XML_RSS_INCLUDED")) {
    define("ERCX_XML_RSS_INCLUDED", 1); 

    /**
     * Description
     * 
     * @param type $var description
     * @return type description
     * @link 
     */
    class xml_rss {
        var $buffer;
        var $count;
        
        var $channel_title;
        var $channel_link;
        var $channel_description;
        
        var $image_title;
        var $image_url;
        var $image_link;
        var $image_description;
        var $image_height = 31;
        var $image_width = 88;
        var $max_items = 10;
        var $max_item_description = 200;
        var $rss_file;
        var $item_date;
        var $author;
        var $category;
        var $domain;
        var $ttl = 120;
        var $enclosure = array();

        function xml_rss($rss_file)
        {
            global $meta;

            $this->rss_file = $rss_file;
            $this->channel_title = $meta['title'];
            $this->channel_link = RCX_URL . "/";
            $this->channel_description = $meta['description'];
            $this->image_title = $meta['title'];
            $this->image_url = RCX_URL . "/images/button.gif";
            $this->image_link = RCX_URL . "/";
            $this->image_description = $meta['slogan'];
        } 

        /**
         * Description
         * 
         * @param type $var description
         * @return type description
         */
        function render()
        {
            global $meta, $rcxConfig;

            $content = '<?xml version="1.0" encoding="' . _CHARSET . '"?>';
            $content .= "\n<rss version='2.0'>\n";
            $content .= "<channel>\n";
            $content .= "<title>" . $this->cleanup($this->channel_title) . "</title>\n";
            $content .= "<link>" . $this->channel_link . "</link>\n";
            $content .= "<description>" . $this->cleanup($this->channel_description) . "</description>\n";
            $content .= "<language>" . _LANGCODE . "</language> \n";
            $content .= "<copyright>Copyright " . date("Y") . ", " . $meta["author"] . "</copyright> \n";
            $content .= "<webMaster>" . $rcxConfig['adminmail'] . "</webMaster> \n";
            $content .= "<managingEditor>" . $rcxConfig['adminmail'] . "</managingEditor> \n";
            $content .= "<pubDate>" . date("r") . "</pubDate> \n";
            $content .= "<generator>" . RCX_VERSION . "</generator> \n";
            $content .= "<ttl>" . $this->ttl . "</ttl> \n";
            $content .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs> \n";
            $content .= "<image>\n";
            $content .= "<title>" . $this->cleanup($this->image_title) . "</title>\n";
            $content .= "<url>" . $this->image_url . "</url>\n";
            $content .= "<link>" . $this->image_link . "</link>\n";
            $content .= "<description>" . $this->cleanup($this->image_description) . "</description>\n";
            $content .= "<width>" . $this->image_width . "</width>\n";
            $content .= "<height>" . $this->image_height . "</height>\n";
            $content .= "</image>\n";
            $content .= $this->buffer;
            $content .= "</channel>\n";
            $content .= "</rss>";

            return $content;
        } 

        function save()
        {
            if ($fp = @fopen($this->rss_file, "w")) {
                fwrite($fp, $this->render());
                fclose($fp);
            } else {
                return false;
            } 

            return true;
        } 
        /**
         * Description
         * 
         * @param type $var description
         * @return type description
         */
        function build($title, $link, $desc = '')
        {
            if ($this->count < $this->max_items) {
                if (!empty($desc)) {
                    $description = $this->cleanup($desc, $this->max_item_description);
                } 

                $this->buffer .= "<item>\n";
                $this->buffer .= "<title>" . $this->cleanup($title) . "</title>\n";
                $this->buffer .= "<link>" . $link . "</link>\n";
                $this->buffer .= "<guid isPermaLink='true'>" . $link . "</guid>\n";
                if (!empty($this->author)) {
                    $this->buffer .= "<author>" . $this->author . "</author>\n";
                } 
                if (!empty($this->item_date)) {
                    $this->buffer .= "<pubDate>" . date("r", $this->item_date) . "</pubDate>\n";
                } 

                if (!empty($desc)) {
                    $this->buffer .= "<description>" . $description . "...</description>\n";
                } 

                if (!empty($this->enclosure)) {
                    $this->buffer .= "<enclosure url='" . $this->enclosure['url'] . "' length='" . $this->enclosure['length'] . "' type='" . $this->enclosure['type'] . "' />\n";
                } 

                if (!empty($this->category) && !empty($this->domain)) {
                    $this->buffer .= "<category domain='" . $this->domain . "'>" . $this->cleanup($this->category) . "</category>\n";
                } 
                $this->buffer .= "</item>\n";

                $this->count++;
            } 
        } 
        /**
         * Description
         * 
         * @param type $var description
         * @return type description
         */
        function cleanup($text, $trim = 100)
        {
            global $myts;

            $clean = stripslashes($text);
            //$clean = $myts->sanitizeForDisplay($clean, 1, 0, 1);
            $clean = $myts->undoHtmlSpecialChars($clean);
            $clean = strip_tags($clean);
            $clean = substr($clean, 0, $trim);
            $clean = htmlspecialchars($clean, ENT_QUOTES, RCX_ENT_ENCODING);

            return $clean;
        } 

        function setCategory($category, $domain)
        {
            $this->category = $category;
            $this->domain = $domain;
        } 

        function setItemDate($date)
        {
            $this->item_date = $date;
        } 

        function setAuthor($author)
        {
            $this->author = $author;
        } 

        function setEnclosure($url, $length, $type)
        {
            if (!empty($url) && !empty($length) && !empty($type)) {
                $this->enclosure['url'] = $url;
                $this->enclosure['length'] = $length;
                $this->enclosure['type'] = $type;
            } 
        } 
    } // END XMLRSS   
} 

?>