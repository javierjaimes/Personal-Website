<?php
Load::_class("packages_interfaces_methods");

class Feed extends Api implements Methods{
	
        public function GET(){
            //header("Content-Type: application/xml; charset=UTF-8");
            $xml = "<?xml version=\"1.0\"?>";
            $xml .= "<rss version=\"2.0\" xmlns:blogChannel=\"Me!\">";
            $xml .= "<channel>";
            $xml .= "<title>Me!</title>";
            $xml .= "<link>".URL."</link>";
            $xml .= "<description>SigueMe!.</description>";
            $xml .= "<language>es-ES</language>";
            $xml .= "<copyright>Copyright 1997-2002 Me!</copyright>";
            $xml .= "<generator>Me! 30/07/09</generator>";
            $xml .= "<webMaster>Me1</webMaster>";
            $xml .= "<language>es-ES</language>";
            
            $published = $this->resource->get("publish");
            if(!$published)
                return false;
                
            foreach($published as $node){
                $xml .= "<item>
                    <title>".$node['text']."</title>
                    <link>" . URL . "/?state=" . $node['states'] . "</link>
                    <description><![CDATA[". strip_tags($node['text']). "]]></description>
                    <author></author>
                    <guid isPermaLink=\"false\">" . URL . "/?state=" . $node['states'] . "</guid>
                    <pubDate>" . $node['register']."</pubDate>
                </item>";
            }

            $xml .= "</rss>";
            
            return $xml;
            
        }
        public function PUT(){
            return false;
        }
        public function POST(){
            return false;
        }
        public function DELETE(){
            return false;
        }	
}
?>