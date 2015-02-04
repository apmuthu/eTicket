<?php
$rss_template = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>%site_title</title>
    <link>%url</link>
    <description>%site_title</description>
    <language>en-us</language>
%items
  </channel>
</rss>';
$item_template = '
    <item>
      <title>%ticket</title>
      <description>%subject</description>
      <pubDate>%date</pubDate>
      <guid isPermaLink="true">%link</guid>
      <link>%link</link>
    </item>';
?>
