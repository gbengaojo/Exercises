<?php

N2Loader::import('libraries.slider.generator.abstract', 'smartslider');

class N2GeneratorPostsPosts extends N2GeneratorAbstract
{

    protected function _getData($count, $startIndex) {
        global $post;
        $tmpPost = $post;

        list($orderBy, $order) = N2Parse::parse($this->data->get('postscategoryorder', 'post_date|*|desc'));

        $postsFilter = array(
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'post',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'offset'           => $startIndex,
            'posts_per_page'   => $count,
            'orderby'          => $orderBy,
            'order'            => $order
        );

        $categories = (array)N2Parse::parse($this->data->get('postscategory'));
        if (!in_array(0, $categories)) {
            $postsFilter['category'] = implode(',', $categories);
        }

        $posts = get_posts($postsFilter);

        $data = array();
        for ($i = 0; $i < count($posts); $i++) {
            $record = array();

            $post = $posts[$i];
            setup_postdata($post);

            $record['id'] = $post->ID;


            $record['url']         = get_permalink();
            $record['title']       = apply_filters('the_title', get_the_title());
            $record['description'] = $record['content'] = get_the_content();
            $record['author_name'] = $record['author'] = get_the_author();
            $record['author_url']  = get_the_author_meta('url');
            $record['date']        = get_the_date();
            $record['excerpt']     = get_the_excerpt();
            $record['modified']    = get_the_modified_date();

            $category = get_the_category($post->ID);
            if (isset($category[0])) {
                $record['category_name'] = $category[0]->name;
                $record['category_link'] = get_category_link($category[0]->cat_ID);
            } else {
                $record['category_name'] = '';
                $record['category_link'] = '';
            }

            $record['featured_image'] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if (!$record['featured_image']) $record['featured_image'] = '';

            $record['thumbnail'] = $record['image'] = $record['featured_image'];
            $record['url_label'] = 'View post';

            if (class_exists('acf')) {
                $fields = get_fields($post->ID);
                if (count($fields)) {
                    foreach ($fields AS $k => $v) {
                        $record[$k] = $v;
                    }
                }
            }

            $data[$i] = &$record;
            unset($record);
        }

        wp_reset_postdata();
        $post = $tmpPost;
        if ($post) setup_postdata($post);

        return $data;
    }
}