#-*- coding: utf-8 -*-
from django.contrib import admin
from blog.models import Post, Category, Comment

class PostAdmin(admin.ModelAdmin):
	list_display        = ('title','category', 'date', 'user')
	ordering            = ['-date']
	prepopulated_fields = {"slug": ("title",)}

	def save_model(self, request, obj, form, change):
		from django.core.cache import cache
		cache.clear()
		super(self.__class__, self).save_model(request, obj, form, change)

class CategoryAdmin(admin.ModelAdmin):
	list_display        = ('name', )
	prepopulated_fields = {"slug": ("name",)}


class CommentAdmin(admin.ModelAdmin):
	list_display        = ('username','mail', 'created', )

admin.site.register(Post, PostAdmin)
admin.site.register(Category, CategoryAdmin)
admin.site.register(Comment, CommentAdmin)