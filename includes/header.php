<?php
 // var_dump($wgUser);
/**
 * Returns the session identifier for the user.
 * Otherwise returns false for an anonymous user.
 * @param  string $cookieName The name of the cookie to check for a session
 * @return [mixed] session identifier (which would evaluate to true) or false
 */
function getSessionIdFromCookie ($cookieName="fssessionid") {
	$sessionId = null;
	$sessionId = @$_COOKIE["$cookieName"];

	if ( !is_null( $sessionId ) && !empty( $sessionId ) ) {
		return $sessionId;
	} else {
		return false;
	}
}

/**
 * Check if a user has a certain permission. Defaults to checking the
 * ViewTempleUIPermission permission.
 * @param  [integer] $sessionId A valid session identifier
 * @param  string $perm      The permission to check
 * @return [bool] True if user has permission; else False
 */
function checkTemplePermission ($sessionId=null, $perm="ViewTempleUIPermission") {
	if (is_null($sessionId)) {
		return false;
	}
	if ( !empty($sessionId) ) {
		$endpoint = "https://www.familysearch.org/service/ident/cas/cas-public-api/authorization/v1/authorize?perm=$perm&context=FtNormalUserContext&sessionId=$sessionId";

		$xml = file_get_contents($endpoint);
		$xml = new SimpleXMLElement($xml);

		$tAuthorized = $xml->authorized->__toString();
		return ($tAuthorized === 'false')? false : true;
	}
}

/**
 * Check for the value of an LDS profile preference. Defaults to check 'showLDSTempleInfo'
 * @param  [int]  $sessionId A session identifier for a logged in user
 * @param  string  $pref  The preference item to retrieve the value of.
 * @return boolean At least in the case of showLDSTempleInfo, the value is true/false
 */
function hasPref ($sessionId, $pref="showLDSTempleInfo") {
	$ch = curl_init("https://www.familysearch.org/service/tree/tree-data/profile/pref/$pref");
	// When we curl_exec, return a string rather than output directly
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	// Send our session cookie in the request
	curl_setopt ($ch, CURLOPT_COOKIE, "fssessionid=$sessionId");
	$json = curl_exec($ch);
	curl_close($ch);
	$objJson = json_decode($json);
	$data = $objJson->{'data'};
	// The data element is itself json encoded
	if ($data) {
		$hasPref = json_decode($data);
		$hasPref = $hasPref->{'pref'};
		return $hasPref;
	}
	return null;
}


?>
<header id="main-header" data-height-onload="74" data-view-service="header">
	<div class="container clearfix et_menu_container">
		<div id="primary-navigation">
         <!-- FamilySearch Logo at the top-left of the page -->
			<div class="logo_container">
				<span class="logo_helper"></span>
				<a href="https://www.familysearch.org/">
               <img src="/wiki/public_html/img/logo.png" alt="<?php $t ('header-fswiki');?>" id="logo" data-height-percentage="54">
            </a>
         </div>  <!-- end .logo_container -->
         <div id="et-top-navigation" data-height="66" data-fixed-height="40">
            <div id="header-right-section">
               <div id="secondary-navigation">
                  <div class="container clearfix">
                     <div id="et-secondary-menu">
                        <div class="menu-header-links-top-container">
                           <ul id="menu-header-links-top" class="menu">
								 <!-- 20190417 - added messages -->
								 <li class="upper-nav-item header-top-link menu-item menu-item-type-custom menu-item-object-custom messages">
									<a style="color:black!important;" href="https://www.familysearch.org/messaging/mailbox" target="_blank" data-test="header-nav-messages" data-component="AdobeLinkTracker" data-config="{&quot;type&quot;: &quot;o&quot;, &quot;name&quot;: &quot;li_hdr_msgs&quot;}">
										<?php $t ('header-messages');?>
											<!--
												<span id="desktop-messages-badge" class="red-badge fs-messages-badge fs-badge hf-hide">
											</span>-->
									</a>
								</li>
                              <!-- Volunteer link - top-right of the page -->
                              <li id="menu-item-39416"
                                 class="header-top-link menu-item menu-item-type-custom menu-item-object-custom menu-item-39416">
                                 <a style="color:black!important;" href="https://www.familysearch.org/ask/volunteer"><?php $t ('header-volunteer');?></a>
                              </li>
                              <!-- Help menu at the top-right of the page -->
                              <li id="menu-item-39417"
                                 class="header-top-link menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39417">
                                 <a style="color:black!important;" href="#"><?php $t ('header-help');?></a>
                                 <ul class="sub-menu">
                                    <!-- Create search box in Help dropdown menu -->
                                    <form class="search-form" method="get"
                                       action="https://www.familysearch.org/ask/landing?search=add+a+name&amp;show=all&amp;button=">
                                       <input type="hidden" name="show" value="all">
                                       <label>
                                          <span class="screen-reader-text"><?php $t ('header-searchfor');?>:
                                          </span>
                                          <input class="search-field" type="text" name="search"
                                             placeholder="<?php $t ('header-searchboxplaceholder');?>">
                                       </label>
                                       <input value="" class="search-submit" type="submit" name="button"
                                          data-component-init="AdobeLinkTracker">
                                    </form>
                                    <!-- Help Center -->
                                    <li id="menu-item-39418"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39418">
                                       <a href="https://www.familysearch.org/ask/landing"><?php $t ('header-helpcenter');?></a>
                                    </li>
                                    <!-- Getting Started -->
                                    <li id="menu-item-39420"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39420">
                                       <a href="https://www.familysearch.org/ask/gettingStarted"><?php $t ('header-gettingstarted');?></a>
                                    </li>
                                    <!-- Contact Us -->
                                    <li id="menu-item-39421"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39421">
                                       <a href="https://www.familysearch.org/ask/help"><?php $t ('header-contactus');?></a>
                                    </li>
                                    <!-- Learning Center -->
                                    <li id="menu-item-39422"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39422">
                                       <a href="https://www.familysearch.org/ask/landing?search=Getting%20Started&amp;show=lessons&amp;message=true"><?php $t ('header-learningcenter');?></a>
                                    </li>
                                    <!--Community -->
                                    <li id="menu-item-39423"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39423">
                                       <a href="https://www.familysearch.org/ask/communities"><?php $t ('header-community');?></a>
                                    </li>
                                    <!-- My Cases -->
                                    <li id="menu-item-39424"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39424">
                                       <a href="https://www.familysearch.org/ask/mycases#/"><?php $t ('header-mycases');?></a>
                                    </li>
                                    <!-- Research Wiki -->
                                    <li id="menu-item-39427"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39427">
                                       <a href="/wiki/en"><?php $t ('header-researchwiki');?></a>
                                    </li>
                                    <!--What's New -->
                                    <li id="menu-item-39425"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39425">
                                       <a href="https://www.familysearch.org/blog/en/category/about-familysearch/whats-new-at-familysearch"><?php $t ('header-whatsnew');?></a>
                                    </li>
                                    <!-- Consultant Resources -->
                                    <li id="menu-item-39426"
                                       class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39426">
                                       <a href="https://www.familysearch.org/ask/planner/calling"><?php $t ('header-consultantresources');?></a>
                                    </li>
                                 </ul>
                              </li>
                           </ul>
                        </div>
                     </div><!-- #et-secondary-menu -->
                  </div> <!-- .container -->
               </div><!-- #secondary-navigation -->
               <!-- Sign in and Register links -->
               <!-- The following lines of code create the Sign In and the Free Account button at the top right of the wiki page  -->
               <!--  It is important to be aware that the formatting has been hardcoded because of conflicts with flex coding that has been  -->
               <!--  Added to the header menu items.  This may cause issues at a later time, so I am flagging it here, just in case.  (Amie)-->
               <div class="menu-header-links-bottom-container">
                  <ul id="menu-header-links-bottom" class="menu">
                     <!-- Sign In link -->
                     <li id="menu-item-38439"
                        class="header-right-link menu-item menu-item-type-custom menu-item-object-custom menu-item-38439"
                        style="float:left; font-size:16px; color:#666662;">
                        <a href="/wiki/<?php $t ('header-language');?>/Special:UserLogin?returnto=<?php echo ( preg_replace (['%^/wiki/(de|en|es|fr|it|ja|ko|pt|ru|sv|zh)/%', '%\?.*$%'], '', $_SERVER['REQUEST_URI']) );?>"><?php $t ('header-signin');?></a>
                     </li>
                     <!-- Free Account button -->
                     <li id="menu-item-38440"
                        class="header-right-button menu-item menu-item-type-custom menu-item-object-custom menu-item-38440"
                        style="float:right; padding:10px;">
                        <a href="https://www.familysearch.org/register/"><?php $t ('header-freeaccount');?></a>
                     </li>
                     <!--20190325 - styled the sign out link -->
				      <li id="logout-link" style="display:none; float:left; font-size:1rem; color:#666662;" class="header-right-link menu-item menu-item-type-custom menu-item-object-custom">
					      <a href="/wiki/<?php $t ('header-language');?>/Special:UserLogout?returnto=<?php echo ( preg_replace (['%^/wiki/(de|en|es|fr|it|ja|ko|pt|ru|sv|zh)/%', '%\?.*$%' ], '', $_SERVER['REQUEST_URI']) );?>" class="user-submenu-link" data-test="NavigationLogOut" data-component="AdobeLinkTracker" data-config="{&quot;type&quot;: &quot;o&quot;, &quot;name&quot;: &quot;li_hdr_signout&quot;}">
                    <?php $t ('header-signout');?>
					         </a>
				      </li>
                  </ul>
               </div><!-- end Sign In and Free Account section of header code -->
            </div>  <!-- end #header-right-section -->

			<!-- Mobile view menu, under the MORE Hamburger menu.-->
            <div id="et_mobile_nav_menu">
               <div class="mobile_nav closed">
                  <span class="mobile_menu_bar mobile_menu_bar_toggle"><?php $t ('header-more');?></span>

                  <ul id="top-menu" class="nav">
					<?php if ( ${wgUser['mId']} == 0 ) { ?>
					<div class="mobile-account ">

					 <a href="/auth/familysearch/login?fhf=true" class="mobile-account-first fs-button fs-button--small fs-button--recommended" data-config="lo_hdr_login" data-component-init="AdobeLinkTracker"><?php $t ('header-signin');?></a>

					 <a href="/register/" class="mobile-account-last fs-button fs-button--small" data-config="lo_hdr_register" data-component-init="AdobeLinkTracker"><?php $t ('header-freeaccount');?></a>

	   				</div>
					<?php } ?>

                     <!-- Mobile view - Family Tree menu  with dropdown menu items -->
                     <li id="menu-item-39787" class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39787">
                        <a href="https://www.familysearch.org/tree/pedigree"><?php $t ('header-familytree');?></a>
                        <!-- begin dropdown menu items in Family Tree -->
                        <ul class="sub-menu"  rel="0" style="display: none;">
                           <!-- Family Tree -> Tree menu item -->
                           <li id="menu-item-39788"
                              class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39788">
                              <a href="https://www.familysearch.org/tree/pedigree"><?php $t ('header-tree');?></a>
                           </li>
                           <!-- Family Tree -> Person menu item -->
                           <li id="menu-item-39789"
                              class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39789">
                              <a href="https://www.familysearch.org/tree/person"><?php $t ('header-person');?></a>
                           </li>
                           <!-- Family Tree -> Find menu item -->
                           <li id="menu-item-39790"
                              class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39790">
                              <a href="https://www.familysearch.org/tree/find"><?php $t ('header-find');?></a>
                           </li>
                           <!-- Family Tree -> Lists menu item -->
                           <li id="menu-item-39791"
                              class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39791">
                              <a href="https://www.familysearch.org/tree/list/people"><?php $t ('header-lists');?></a>
                           </li>
                           <!-- Family Tree -> Family Booklet menu item -->
                           <li id="menu-item-39792"
                              class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39792">
                              <a href="https://www.familysearch.org/myfamily/"><?php $t ('header-familybooklet');?></a>
                           </li>
                        </ul>
                     </li>  <!-- end of Family Tree menu item and dropdown menu -->
                     <!-- Mobile view - Search header item with dropdown menu items -->
                     <li id="menu-item-39793" class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39793">
                        <a href="https://www.familysearch.org/search"><?php $t ('header-search');?></a>
                        <!-- begin Search dropdown menu -->
                        <ul class="sub-menu"  rel="0" style="display: none;">
                           <!-- Search -> Records -->
                           <li id="menu-item-39794"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39794">
                              <a href="https://www.familysearch.org/records"><?php $t ('header-records');?></a>
                           </li>
                           <!-- Search -> Family Tree -->
                           <li id="menu-item-39795"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39795">
                              <a href="https://www.familysearch.org/tree/find/name"><?php $t ('header-familytree');?></a>
                           </li>
                           <!-- Search -> Genealogies -->
                           <li id="menu-item-39796"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39796">
                              <a href="https://www.familysearch.org/search/tree"><?php $t ('header-genealogies');?></a>
                           </li>
                           <!-- Search -> Catalog -->
                           <li id="menu-item-39797"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39797">
                              <a href="https://www.familysearch.org/search/catalog"><?php $t ('header-catalog');?></a>
                           </li>
                           <!-- Search -> Books -->
                           <li id="menu-item-39798"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39798">
                              <a href="https://books.familysearch.org/"><?php $t ('header-books');?></a>
                           </li>
                           <!-- Search -> Research Wiki -->
                           <li id="menu-item-39799"
                              class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39799">
                              <a href="/wiki/en/Main_Page"><?php $t ('header-researchwiki');?></a>
                           </li>
                        </ul>
                     </li>
                     <!-- Mobile view - Memories dropdown menu in header -->
                     <li id="menu-item-39800" class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39800">
                        <a href="https://www.familysearch.org/photos/"><?php $t ('header-memories');?></a>
                        <ul class="sub-menu"  rel="0" style="display: none;">
                           <!-- Memories -> Overview -->
                           <li id="menu-item-39801"
                              class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39801">
                              <a href="https://www.familysearch.org/photos/"><?php $t ('header-overview');?></a>
                           </li>
                           <!-- Memories -> Gallery -->
                           <li id="menu-item-39802"
                              class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39802">
                              <a href="https://www.familysearch.org/photos/gallery"><?php $t ('header-gallery');?></a>
                           </li>
                           <!-- Memories -> People -->
                           <li id="menu-item-39803"
                              class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39803">
                              <a href="https://www.familysearch.org/photos/people"><?php $t ('header-people');?></a>
                           </li>
                           <!-- Memories -> Find -->
                           <li id="menu-item-39804"
                              class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39804">
                              <a href="https://www.familysearch.org/photos/find"><?php $t ('header-find');?></a>
                           </li>
                        </ul>
                     </li><!-- end Memories menu item -->
                     <!-- Mobile view - Indexing dropdown menu in header -->
                     <li id="menu-item-39805"
                        class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39805">
                        <a href="https://www.familysearch.org/indexing/"><?php $t ('header-indexing');?></a>
                        <ul class="sub-menu"  rel="0" style="display: none;">
                           <!-- Indexing -> Overview -->
                           <li id="menu-item-39806"
                              class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39806">
                              <a href="https://www.familysearch.org/indexing/"><?php $t ('header-overview');?></a>
                           </li>
                           <!-- Memories -> Web Indexing -->
                           <li id="menu-item-39807"
                              class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39807">
                              <a href="https://www.familysearch.org/indexing/my-indexing"><?php $t ('header-webindexing');?></a>
                           </li>
                           <!-- Memories -> Find A Project -->
                           <li id="menu-item-39808"
                              class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39808">
                              <a href="https://www.familysearch.org/indexing/projects"><?php $t ('header-findaproject');?></a>
                           </li>
                           <!-- Memories -> Help Resources -->
                           <li id="menu-item-39809"
                              class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39809">
                              <a href="https://www.familysearch.org/indexing/help/"><?php $t ('header-helpresources');?></a>
                           </li>
                        </ul>
                     </li> <!-- end Indexing menu item -->
                     <!-- Mobile view - Help menu dropdown -->
                     <li
                     class="header-top-link icon-help menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39417">
                     <a href="#"><?php $t ('header-help');?></a>
                     <ul class="sub-menu" rel="0" style="display: none;">
                        <!-- Help -> Volunteer -->
                        <li
                           class="header-top-link menu-item menu-item-type-custom menu-item-object-custom menu-item-39416">
                           <a href="https://www.familysearch.org/ask/volunteer"><?php $t ('header-volunteer');?></a>
                        </li>
                        <!-- Help -> Help Center -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39418">
                           <a href="https://www.familysearch.org/ask/landing"><?php $t ('header-helpcenter');?></a>
                        </li>
                        <!-- Help -> Getting Started -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39420">
                           <a href="https://www.familysearch.org/ask/gettingStarted"><?php $t ('header-gettingstarted');?></a>
                        </li>
                        <!-- Help -> Contact Us -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39421">
                           <a href="https://www.familysearch.org/ask/help"><?php $t ('header-contactus');?></a>
                        </li>
                        <!-- Help -> Learning Center -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39422">
                           <a
                              href="https://www.familysearch.org/ask/landing?search=Getting%20Started&amp;show=lessons&amp;message=true"><?php $t ('header-learningcenter');?></a>
                        </li>
                        <!-- Help -> Community -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39423">
                           <a href="https://www.familysearch.org/ask/communities"><?php $t ('header-community');?></a>
                        </li>
                        <!-- Help -> My Cases -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39424">
                           <a href="https://www.familysearch.org/ask/mycases#/"><?php $t ('header-mycases');?></a>
                        </li>
                        <!-- Help -> Research Wiki -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39427">
                           <a href="/wiki/en"><?php $t ('header-researchwiki');?></a>
                        </li>
                        <!-- Help -> What's New -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39425">
                           <a href="https://www.familysearch.org/blog/en/category/about-familysearch/whats-new-at-familysearch"><?php $t ('header-whatsnew');?></a>
                        </li>
                        <!-- Help -> Consultant Resources -->
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39426">
                           <a href="https://www.familysearch.org/ask/planner/calling"><?php $t ('header-consultantresources');?></a>
                        </li>
                     </ul>
                  </li>
               </ul><!-- end mobile-nav-view -->
               <div class="mobile-menu-overlay"></div>
            </div>
         </div>
         <!-- Top menu for full screen displays -->
         <nav id="top-menu-nav" style="background-color:#fff;">
               <ul id="top-menu" class="nav">
                  <!-- Full display - Family Tree menu item with dropdown menu -->
                  <li
                     class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39787">
                     <a href="https://www.familysearch.org/tree/pedigree"><?php $t ('header-familytree');?></a>
                     <!-- start dropdown menu for Family Tree -->
                     <ul class="sub-menu">
                        <!-- Family Tree - Tree -->
                        <li class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39788">
                           <a href="https://www.familysearch.org/tree/pedigree"><?php $t ('header-tree');?></a>
                        </li>
                        <!-- Family Tree -> Person -->
                        <li class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39789">
                           <a href="https://www.familysearch.org/tree/person"><?php $t ('header-person');?></a>
                        </li>
                        <!-- Family Tree -> Find -->
                        <li class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39790">
                           <a href="https://www.familysearch.org/tree/find"><?php $t ('header-find');?></a>
                        </li>
                        <!-- Family Tree -> Lists -->
                        <li class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39791">
                           <a href="https://www.familysearch.org/tree/list/people"><?php $t ('header-lists');?></a>
                        </li>
                        <!-- Family Tree -> Family Booklet -->
                        <li class="menu-item icon-tree menu-item-type-custom menu-item-object-custom menu-item-39792">
                           <a href="https://www.familysearch.org/myfamily/"><?php $t ('header-familybooklet');?></a>
                        </li>
                     </ul>
                  </li>  <!-- end Family Tree menu item in full display header -->
                  <!-- Full display - Search menu with dropdown menu -->
                  <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39793">
                     <a href="https://www.familysearch.org/search"><?php $t ('header-search');?></a>
                     <!-- Create dropdown menu-->
                     <ul class="sub-menu">
                        <!-- Search -> Records -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39794">
                           <a href="https://www.familysearch.org/search"><?php $t ('header-records');?></a>
                        </li>
                        <!-- Search -> Family Tree -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39795">
                           <a href="https://www.familysearch.org/tree/find/name"><?php $t ('header-familytree');?></a>
                        </li>
                        <!-- Search -> Genealogies -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39796">
                           <a href="https://www.familysearch.org/search/tree"><?php $t ('header-genealogies');?></a>
                        </li>
                        <!-- Search -> Catalog -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39797">
                           <a href="https://www.familysearch.org/search/catalog"><?php $t ('header-catalog');?></a>
                        </li>
                        <!-- Search -> Books -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39798">
                           <a href="https://books.familysearch.org/"><?php $t ('header-books');?></a>
                        </li>
                        <!-- Search -> Research Wiki -->
                        <li class="menu-item icon-search menu-item-type-custom menu-item-object-custom menu-item-39799">
                           <a href="/wiki/en/Main_Page"><?php $t ('header-researchwiki');?></a>
                        </li>
                     </ul>
                  </li><!-- end Search menu and dropdown -->
                  <!-- Full display - Create Memories menu item and dropdown menu -->
                  <li class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39800">
                     <a href="https://www.familysearch.org/photos/"><?php $t ('header-memories');?></a>
                     <!-- Start dropdown menu -->
                     <ul class="sub-menu">
                        <!-- Memories -> Overview  -->
                        <li class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39801">
                           <a href="https://www.familysearch.org/photos/"><?php $t ('header-overview');?></a>
                        </li>
                        <!-- Memories -> Gallery  -->
                        <li class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39802">
                           <a href="https://www.familysearch.org/photos/gallery"><?php $t ('header-gallery');?></a>
                        </li>
                        <!-- Memories -> People -->
                        <li class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39803">
                           <a href="https://www.familysearch.org/photos/people"><?php $t ('header-people');?></a>
                        </li>
                        <!-- Memories -> Find -->
                        <li class="menu-item icon-memories menu-item-type-custom menu-item-object-custom menu-item-39804">
                           <a href="https://www.familysearch.org/photos/find"><?php $t ('header-find');?></a>
                        </li>
                     </ul>
                  </li><!-- end Memories menu item and dropdown menu -->
                  <!-- Full display - Start Indexing header menu item, with dropdown menu -->
                  <li class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-39805">
                     <a href="https://www.familysearch.org/indexing/"><?php $t ('header-indexing');?></a>
                     <!-- Start dropdown menu -->
                     <ul class="sub-menu">
                        <!-- Indexing -> Overview -->
                        <li class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39806">
                           <a href="https://www.familysearch.org/indexing/"><?php $t ('header-overview');?></a>
                        </li>
                        <!-- Indexing -> Web Indexing -->
                        <li class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39807">
                           <a href="https://www.familysearch.org/indexing/my-indexing"><?php $t ('header-webindexing');?></a>
                        </li>
                        <!-- Indexing -> Find a Project -->
                        <li class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39808">
                           <a href="https://www.familysearch.org/indexing/projects"><?php $t ('header-findaproject');?></a>
                        </li>
                        <!-- Indexing -> Help Resources -->
                        <li class="menu-item icon-indexing menu-item-type-custom menu-item-object-custom menu-item-39809">
                           <a href="https://www.familysearch.org/indexing/help/"><?php $t ('header-helpresources');?></a>
                        </li>
                     </ul> <!-- end Indexing menu item and dropdown -->
                  </li>
<?php
// Show the Temple Menu
$sessionId = getSessionIdFromCookie();
if ( $sessionId ) {
	$hasPermission = checkTemplePermission ($sessionId);
	$hasPref = hasPref($sessionId);
	if ($hasPermission && $hasPref) {
		include ('templeMenu.php');
	}
}

?>
               </ul>
		   </nav> <!-- end Full display top menu -->
         </div><!-- #et-top-navigation -->
      </div><!-- #primary-navigation -->
   </div><!-- .container -->
   <div class="et_search_outer">
      <div class="container et_search_form_container">
         <!-- the following line may need to be changed in order to search the correct location, currently searching the blog? -->
         <form role="search" method="get" class="et-search-form" action="https://familysearch.org/blog">
            <input type="search" class="et-search-field" placeholder="<?php $t ('header-searchboxplaceholder');?>" value="" name="s"
               title="<?php $t ('header-searchfor');?>:">
         </form>
         <span class="et_close_search_field"></span>
      </div> <!-- end .container -->
     </div>  <!-- end .et_search_outer -->
</header>
