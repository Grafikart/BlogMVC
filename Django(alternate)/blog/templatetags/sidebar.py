#-*- coding: utf-8 -*-
from django import template
from django.core.cache import cache
from blog.models import Post, Category
from django.db.models import Count

register = template.Library()

@register.inclusion_tag('blog/latest_posts.html', takes_context=True)
def latest_posts(context):
    u""" List a lastest posts """
    
    latest_posts = Post.objects.filter().order_by('-date')[:2]
    return {'posts' : latest_posts}

@register.inclusion_tag('blog/categories.html', takes_context=True)
def categories(context):
    u""" List of categories """
    
    categories = Category.objects.all()
    return {'categories' : categories}