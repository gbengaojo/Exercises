<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;

/**
 * A class to create a dropdown for all categories in your wordpress site
 */
class Eightstore_lite_Typography_Dropdown extends WP_Customize_Control
{
  public $type = 'select';
    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content()
    {
      ?>
      <label>
        <span class="customize-control-title"><?php echo ( $this->label ); ?></span>
        <select class="typography-selected" data-customize-setting-link="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
          <option value=""><?php echo __('Choose Fonts','eightstore-lite');?></option>
          <option value="Open Sans,sans-serif">"Open Sans",sans-serif</option>
          <option value="Roboto Condensed,sans-serif">"Roboto Condensed",sans-serif</option>
          <option value="Arimo,sans-serif">"Arimo",sans-serif</option>
          <option value="Slabo 27px, serif">"Slabo 27px", serif;</option>
          <option value="Oswald, sans-serif">"Oswald", sans-serif;</option>
          <option value="Lato, sans-serif">"Lato", sans-serif;</option>
          <option value="Source Sans Pro, sans-serif">"Source Sans Pro", sans-serif;</option>
          <option value="PT Sans, sans-serif">"PT Sans", sans-serif;</option>
          <option value="Droid Sans, sans-serif">"Droid Sans", sans-serif;</option>
          <option value="Raleway, sans-serif">"Raleway", sans-serif;</option>
          <option value="Droid Serif, serif">"Droid Serif", serif;</option>
          <option value="Ubuntu, sans-serif">"Ubuntu", sans-serif;</option>
          <option value="Montserrat, sans-serif">"Montserrat", sans-serif;</option>
          <option value="Roboto Slab, serif">"Roboto Slab", serif;</option>
          <option value="Merriweather, serif">"Merriweather", serif;</option>
          <option value="Lora, serif">"Lora", serif;</option>
          <option value="PT Sans Narrow, sans-serif">"PT Sans Narrow", sans-serif;</option>
          <option value="Bitter, serif">"Bitter", serif;</option>
          <option value="Lobster, cursive">"Lobster", cursive;</option>
          <option value="Yanone Kaffeesatz, sans-serif">"Yanone Kaffeesatz", sans-serif;</option>
          <option value="Arvo, serif">"Arvo", serif;</option>
          <option value="Oxygen, sans-serif">"Oxygen", sans-serif;</option>
          <option value="Titillium Web, sans-serif">"Titillium Web", sans-serif;</option>
          <option value="Dosis, sans-serif">"Dosis", sans-serif;</option>
          <option value="Ubuntu Condensed, sans-serif">"Ubuntu Condensed", sans-serif;</option>
          <option value="Cabin, sans-serif">"Cabin", sans-serif;</option>
          <option value="Playfair Display, serif">"Playfair Display", serif;</option>
          <option value="Muli, sans-serif">"Muli", sans-serif;</option>
        </select>
        <span class="description customize-control-description"><?php echo ( $this->description ); ?></span>
      </label>
      <?php
    }
  }
  ?>