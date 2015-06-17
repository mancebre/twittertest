<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ekomi Twitter</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" href="http://use.typekit.net/c/1e5472/1w;brandon-grotesque,2,Y2n:P:n5,Y2q:P:n7;ff-enzo-web,2,Vcn:P:i3,Vcm:P:n3;open-sans,2,VvD:P:i4;proxima-nova,2,b5t:P:n3,b5y:P:n6,bBh:P:n7;pt-sans,2,WkK:P:n4,WkL:P:n7/d?3bb2a6e53c9684ffdc9a98f31c5b2a62f1c741504d00d3f6062e51a3be457e1f39cdbaea0f02affcec16987c30a2d2e3d38a6631b37f0114a2701e52597b05f459ba643eaff8819a4ec2e1f6dcd4d8a46d33c8a73d2ffd0e7f2766e9b9ef541175bb88bf77125e3900887beaa9cc45093c23e9889096a54e0375fb307f2fad9fd261439861f1127f6f6a86e7387bcb194eed0a0c626c8f307efcbad6204fef99f1c33871303482efb5f652137349abce23213b336cb1a56c6742d13f024046c60d29fc770d04d8b784f84d6db8de5e4974c744fb96a66e93f849c2e812b4ab956ef6c97cd5a6d6bbb9c34f727cd50461f8f11a0e554c79d628d344d4bc311df8" media="all">
</head>
<body class="page page-id-58 page-template-default">
<header class="main" role="banner">
    <div class="container">
        <p class="logo">					<a href="http://www.ekomi-us.com/us/" title="eKomi" rel="home">
                eKomi					</a>
        </p>				<nav>
            <span class="toggle-menu visible-mobile"></span>
            <div class="menu-header"><ul id="menu-main" class="menu"><li id="menu-item-424" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-424"><a href="http://www.ekomi-us.com/us/#why-ekomi">Why eKomi</a></li>
                    <li id="menu-item-311" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-311"><a href="http://www.ekomi-us.com/us/#how-ekomi-works">How eKomi works</a></li>
                    <li id="menu-item-312" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children menu-item-312"><a href="http://www.ekomi-us.com/us/#listen-clients">References</a>
                        <ul class="sub-menu">
                            <li id="menu-item-327" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-327"><a href="http://www.ekomi-us.com/us/testimonials/">Testimonials</a></li>
                            <li id="menu-item-313" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-313"><a href="http://www.ekomi-us.com/us/#listen-clients">Clients</a></li>
                            <li id="menu-item-314" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-314"><a href="http://www.ekomi-us.com/us/#ekomi-integration">Partners</a></li>
                        </ul>
                    </li>
                    <li id="menu-item-366" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-58 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-366"><a href="http://www.ekomi-us.com/us/about-ekomi/">About</a>
                        <ul class="sub-menu">
                            <li id="menu-item-370" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-58 current_page_item menu-item-370"><a href="http://www.ekomi-us.com/us/about-ekomi/">Team</a></li>
                            <li id="menu-item-377" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-377"><a href="http://www.ekomi-us.com/us/blog/">Blog</a></li>
                        </ul>
                    </li>
                </ul></div>				</nav>

        <div class="demo"><ul id="menu-demo" class="menu"><li id="menu-item-425" class="login phone menu-item menu-item-type-custom menu-item-object-custom menu-item-425"><a href="tel://001844-356-6487">+1 844-356-6487</a></li>
                <li id="menu-item-315" class="login menu-item menu-item-type-custom menu-item-object-custom menu-item-315"><a target="_blank" href="https://www.ekomi-us.com/login.php">Login</a></li>
            </ul></div>
    </div>
</header>
<div>
    <article>
        <section class="choose">
            <div class="container">
                <?php
                foreach($tweets as $tweet) {
                    ?>
                    <div class="tweet-box">
                        <div class="top-row">
                            <div class="img">
                                <img src="<?php echo $tweet['profileImageUrl']; ?>">
                            </div>
                            <div class="text"><?php echo $tweet['text']; ?></div>
                        </div>
                        <div class="bottom-row">
                            <div class="buttons">
                                <a title="Reply" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $tweet['tweetId']; ?>" target="_blank"><div class="reply"></div></a>
                                <a title="Retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo $tweet['tweetId']; ?>" target="_blank"><div class="retweet"></div></a>
                                <a title="Favorite" href="https://twitter.com/intent/favorite?tweet_id=<?php echo $tweet['tweetId']; ?>" target="_blank"><div class="favorite"></div></a>
                            </div>
                            <div class="datetime"><?php echo $tweet['created']; ?></div>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </article>
</div>
</body>
</html>