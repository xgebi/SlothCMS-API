# SlothCMS specific keywords in Toe Templating Language

## Scripts

```scripts_header``` ```scripts_footer```

## Stylesheets

```stylesheets```

## Sitewide

```site```

```site_name```

```site_section``` e.g. Dashboard, New Post, etc.

## Content specific

### ```posts``` Object

Contains data for posts, so be careful when using it.

Basic ```posts``` contains all published posts regardless of post type.

There's a recomendation to use parametrized posts object:

```
<# posts({ 
  postType: "postType",  
  numberOfPosts: 10,
  postIndex: 0
  }) #>
```

### ```post``` Object

```post``` Object holds information for each post.