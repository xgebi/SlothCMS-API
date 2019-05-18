# Wordpress export file

- based on RSS

#Items

## General
- title
- link
- description
- pubDate
    - possibly latest update?
- language
- wp:author
    - wp:author_id
    - wp:author_login (in CDATA)
    - wp:author_email (in CDATA)
    - wp:author_display_name (in CDATA)
    - wp:author_first_name (in CDATA)
    - wp:author_last_name (in CDATA)
- generator

## Categories
- wp:category
    - wp:term_id
    - wp:category_nicename (in CDATA)
    - wp:category_parent (in CDATA)
    - wp:cat_name (in CDATA)
- wp:tag
    - wp:term_id
    - wp:tag_slug (in CDATA)
    - wp:tag_name (in CDATA)

- wp:term
    - wp:term_id (in CDATA)
    - wp:term_taxonomy (in CDATA)
    - wp:term_slug  (in CDATA)
    - wp:term_parent (in CDATA)
    - wp:term_name (in CDATA)

## Item
- title (string)
- link (string)
- pubDate (String, long version)
- dc:creator  (in CDATA)
- guid[isPermaLink (Boolean)] (String)
- description (???)
- content:encoded (in CDATA)
- excerpt:encoded (in CDATA)
- wp:post_id (number)
- wp:post_date (in CDATA) (yyyy-mm-dd hh-MM-ss)
- wp:post_date_gmt (in CDATA) (yyyy-mm-dd hh-MM-ss)
- wp:comment_status (in CDATA)
- wp:ping_status (in CDATA)
- wp:post_parent (number)
- wp:menu_order (number)
- wp:post_type (in CDATA)
- wp:post_password (in CDATA)
- wp:is_sticky (number)
- wp:attachment_url (in CDATA)
- wp:postmeta
    - wp:meta_key (in CDATA)
    - wp:meta_value (in CDATA) 