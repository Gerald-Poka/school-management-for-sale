@php
    $templates = ['website.each.home.home_1', 'website.each.home.home_2'];
    $selectedTemplate = $templates[array_rand($templates)];
@endphp

@extends($selectedTemplate)