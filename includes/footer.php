
<!-- Create the menu items in the appropriate language for the footer : "About   Blog   Site Map    Solutions Gallery   Cookie Preferences"-->
<div id="fs-footer" style="width:100%; z-index:2; left:-0.25rem; padding-bottom:1.5rem;">
	<!-- when > = 992px -->
	<div class="footer-container">
		<div class="footer-nav">
			<div class="menu-footer-menu-container">
				<ul id="menu-footer-menu" class="menu" style="margin:0!important;">
					<!-- About -->
					<li id="menu-item-39483" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39483">
						<a href="https://www.familysearch.org/home/about"><?php $t ('footer-about');?></a>
					</li>
					<!-- Blog -->
					<li id="menu-item-39484"
						class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-39484">
						<a href="https://familysearch.org/blog/<?php $t ('header-language');?>"><?php $t ('footer-blog');?></a>
					</li>
					<!-- Site Map -->
					<li id="menu-item-39485" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39485">
						<a href="https://www.familysearch.org/site-map"><?php $t ('footer-sitemap');?></a>
					</li>
					<!-- Solutions Gallery -->
					<li id="menu-item-39486" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-39486">
						<a href="https://partners.familysearch.org/solutionsgallery"><?php $t ('footer-solutionsgallery');?></a>
					</li>
				</ul>
			</div>

			<!-- create Cookie Preferences in footer -->

			<span class="menu-item" id="teconsent" consent="0,1,2" style="display: inline;">
				<script async="async" lang="<?php $t ('footer-cookiepref');?>"
					src="//consent.trustarc.com/notice?domain=familysearch.org&amp;c=teconsent&amp;js=nj&amp;noticeType=bb&amp;text=true&amp;oc=1&amp;fade=30000&amp;cdn=1&language=<?php $t ('header-language');?>"
					id="truste_0.740075485905165">
				</script>
			</span>

		</div> <!-- end class="footer-nav" -->

		<div class="copyright-notice">
			<!-- Create FamilySearch Terms of Use (Updated 'date') | Privacy Notice (Updated 'date') -->
			<div class="privacy_usage">
				<a href="https://www.familysearch.org/terms" data-test="footer-rights-of-use" data-component="AdobeLinkTracker"
					data-config="ftr_rights"><?php $t ('footer-termsofuse');?></a> <?php $t ('footer-termsupdated');?>&nbsp;|&nbsp;<a href="https://www.familysearch.org/privacy" data-test="footer-privacy_policy"
					data-component="AdobeLinkTracker" data-config="ftr_privacy"><?php $t ('footer-privacynotice');?>
				</a> <?php $t ('footer-privacyupdated');?>
			</div>
			<!-- Create Ⓒ 2019 by Intellectual Reserve, Inc. -->
			<span>&#x24B8; <?php $t ('footer-intellectualreserve');?></span>
			<span
				class="service-by-link">
				<a href="<?php $t ('footer-footerchurchlogo');?>" data-component="AdobeLinkTracker" data-test="footer-service-by-link"
					data-config="{&quot;type&quot;: &quot;e&quot;, &quot;name&quot;: &quot;ftr_srvcby&quot;}"><?php $t ('footer-ldschurch');?></a>
			</span>
		</div> <!-- end class="copyright-notice" -->

		<!-- Display the correct logo in the footer, based on the language.  See /i18n/*.json file for language specific information -->
		<span class="church-logo-container">
			<a class="church-logo locale-en" href="<?php $t ('footer-mormondotcomurl');?>">
				<img src="<?php $t ('footer-logourl');?>"
					alt="<?php $t ('footer-footerchurchlogo');?>" title="<?php $t ('footer-serviceprovidedby');?>"
					style="margin:1rem 0;"/>
			</a>
		</span> <!-- end class="church-logo-container"  -->
	</div> <!-- end class="footer-container" -->

</div> <!-- end id="fs-footer" -->
