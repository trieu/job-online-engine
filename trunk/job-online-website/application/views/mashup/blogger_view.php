<?php


//print_r($theAccount);

$sample = gdata_blogger_service::getInstance($loginParams);
$query = new Zend_Gdata_Query('http://www.blogger.com/feeds/default/blogs');
//$query = new Zend_Gdata_Query('http://www.blogger.com/feeds/1672527029385884909/posts/default?q="content"');
$feed = $sample->gdClient->getFeed($query);
$sample->printFeed($feed);
//
$sample->blogID = "1672527029385884909";
$sample->printAllPosts();
//
$thePost = $sample->getThePost('3470177348607771341');
echo $thePost->title->text . '<BR>';
//echo $thePost->content->text . '<BR>';

$rows = json_decode($thePost->content->text);
print_r($rows);

//$postID = $sample->createPost('profile 5', '<h1 class="title">test5</h1><br/><center class="attributes" >content5</center>', TRUE);
//
//$thePost = $sample->getThePost($postID);
//echo $thePost->title->text . '<BR>';
//echo $thePost->content->text . '<BR>';