#-*- coding: utf-8 -*-
from django import template
from django.core.cache import cache
from blog.models import Post
from django.db.models import Count

register = template.Library()

@register.inclusion_tag('blog/post.html', takes_context=True)
def latest_posts(context):
    u""" List a lastest posts """
    
    latest_posts = Post.objects.filter().order_by('-date')[:2]
    return {'posts' : latest_posts}