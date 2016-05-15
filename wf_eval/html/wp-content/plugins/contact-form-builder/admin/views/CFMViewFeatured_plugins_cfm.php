<?php

class CFMViewFeatured_plugins_cfm {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    ?>
    <div id="main_featured_plugins_page">
      <table align="center" width="90%" style="margin-top: 0px;border-bottom: rgb(111, 111, 111) solid 2px;">
        <tr>
          <td colspan="2" style="height: 70px;"><h3 style="margin: 0px;font-family:Segoe UI;padding-bottom: 15px;color: rgb(111, 111, 111); font-size:18pt;">Featured Plugins</h3></td>
          <td></td>
        </tr>
      </table>
      <form method="post">
        <ul id="featured-plugins-list">
          <li class="form-maker">
            <div class="product">
              <div class="title">
                <strong class="heading">Form Maker</strong>
                <p>Wordpress form builder plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Form Maker is a modern and advanced tool for creating WordPress forms easily and fast.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-form.html" class="download">Download</a>
            </div>
          </li>
          <li class="photo-gallery">
            <div class="product">
              <div class="title">
                <strong class="heading">Photo Gallery</strong>
                <p>WordPress Photo Gallery plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Photo Gallery is a fully responsive WordPress Gallery plugin with advanced functionality. 
                It allows having different image galleries for your posts and pages, as well as different widgets.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-photo-gallery-plugin.html" class="download">Download</a>
            </div>
          </li>
          <li class="spider-calendar">
            <div class="product">
              <div class="title">
                <strong class="heading">Spider Calendar</strong>
                <p>WordPress event calendar plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Event Calendar is a highly configurable product which allows you to have multiple organized events.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-calendar.html" class="download">Download</a>
            </div>
          </li>
          <li class="catalog">
            <div class="product">
              <div class="title">
                <strong class="heading">Spider Catalog</strong>
                <p>WordPress product catalog plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Catalog for WordPress is a convenient tool for organizing the products represented on your website into catalogs.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-catalog.html" class="download">Download</a>
            </div>
          </li>
          <li class="player">
            <div class="product">
              <div class="title">
                <strong class="heading">Video Player</strong>
                <p>WordPress Video player plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Video Player for WordPress is a Flash & HTML5 video player plugin that allows you to easily add videos to your website with the possibility</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-player.html" class="download">Download</a>
            </div>
          </li>
          <li class="contacts">
            <div class="product">
              <div class="title">
                <strong class="heading">Spider Contacts</strong>
                <p>Wordpress staff list plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Contacts helps you to display information about the group of people more intelligible, effective and convenient.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-contacts-plugin.html" class="download">Download</a>
            </div>
          </li>
          <li class="facebook">
            <div class="product">
              <div class="title">
                <strong class="heading">Spider Facebook</strong>
                <p>WordPress Facebook plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Facebook is a WordPress integration tool for Facebook.It includes all the available Facebook social plugins and widgets to be added to your web</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-facebook.html" class="download">Download</a>
            </div>
          </li>
          <li class="twitter-widget">
            <div class="product">
              <div class="title">
                <strong class="heading">Widget Twitter</strong>
                <p>WordPress Widget Twitter plugin</p>
              </div>
            </div>
            <div class="description">
              <p>The Widget Twitter plugin lets you to fully integrate your WordPress site with your Twitter account.</p>
              <a target="_blank" href="http://web-dorado.com/products/wordpress-twitter-integration-plugin.html" class="download">Download</a>
            </div>
          </li>
          <li class="faq">
            <div class="product">
              <div class="title">
                <strong class="heading">Spider FAQ</strong>
                <p>WordPress FAQ Plugin</p>
              </div>
            </div>
            <div class="description">
                <p>The Spider FAQ WordPress plugin is for creating an FAQ (Frequently Asked Questions) section for your website.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-faq-plugin.html" class="download">Download</a>
            </div>
          </li>
          <li class="zoom">
            <div class="product">
              <div class="title">
                <strong class="heading">Zoom</strong>
                <p>WordPress text zoom plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Zoom enables site users to resize the predefined areas of the web site.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-zoom.html" class="download">Download</a>
            </div>
          </li>
          <li class="flash-calendar">
            <div class="product">
              <div class="title">
                <strong class="heading">Flash Calendar</strong>
                <p>WordPress flash calendar plugin</p>
              </div>
            </div>
            <div class="description">
                <p>Spider Flash Calendar is a highly configurable Flash calendar plugin which allows you to have multiple organized events.</p>
                <a target="_blank" href="http://web-dorado.com/products/wordpress-events-calendar.html" class="download">Download</a>
            </div>
          </li>
        </ul>
      </form>
    </div >
    <?php
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}