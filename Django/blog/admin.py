#-*- coding: utf-8 -*-
from django.contrib import admin
from blog.models import Post

class PostAdmin(admin.ModelAdmin):
	list_display        = ('title', 'date')
	ordering            = ['-date']
	prepopulated_fields = {"slug": ("title",)}

admin.site.register(Post, PostAdmin)