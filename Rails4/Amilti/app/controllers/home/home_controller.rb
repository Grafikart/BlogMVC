class Home::HomeController < ActionController::Base
	layout 'application'
	before_filter :categories, :latest_post

	def categories
		@categories = Category.all
	end

	def latest_post
		@latest_post = Post.order('created_at DESC').limit(2)
	end
end