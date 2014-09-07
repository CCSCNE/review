<?php

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::register('login', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});

Breadcrumbs::register('signup', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Signup', route('signup'));
});

Breadcrumbs::register('author', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Author', route('author'));
});

Breadcrumbs::register('submit', function($breadcrumbs) {
    $breadcrumbs->parent('author');
    $breadcrumbs->push('Submit', route('submit'));
});

Breadcrumbs::register('author.view.submission', function($breadcrumbs) {
    $breadcrumbs->parent('author');
    $breadcrumbs->push('Submission', route('author.view.submission'));
});

Breadcrumbs::register('reviewer', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reviewer', route('reviewer'));
});

Breadcrumbs::register('submit', function($breadcrumbs) {
    $breadcrumbs->parent('reviewer');
    $breadcrumbs->push('Submit', route('submit'));
});

Breadcrumbs::register('view.review', function($breadcrumbs) {
    $breadcrumbs->parent('reviewer');
    $breadcrumbs->push('Review', route('view.review'));
});

Breadcrumbs::register('chair', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Chair', route('chair'));
});


Breadcrumbs::register('chair.view.category', function($breadcrumbs) {
    $breadcrumbs->parent('chair');
    $breadcrumbs->push('Category', route('chair.view.category'));
});

Breadcrumbs::register('delete.document', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Delete Document', route('delete.document'));
});

/*
Breadcrumbs::register('blog', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

Breadcrumbs::register('category', function($breadcrumbs, $category) {
    $breadcrumbs->parent('blog');

    foreach ($category->ancestors as $ancestor) {
        $breadcrumbs->push($ancestor->title, route('category', $ancestor->id));
    }

    $breadcrumbs->push($category->title, route('category', $category->id));
});

Breadcrumbs::register('page', function($breadcrumbs, $page) {
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});
 */
