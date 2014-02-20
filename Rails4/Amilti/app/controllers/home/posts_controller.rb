class Home::PostsController < Home::HomeController

	def index
		@posts = Post.order('created_at DESC').page(params[:page]).per(5)
	end

	def show
		@post = Post.friendly.find(params[:id])
	end

	def category
		@category = Category.friendly.find(params[:id])
		@posts = @category.posts.page(params[:page]).per(5)
	end

	def author
		@author = User.find(params[:id])
		@posts = @author.posts.page(params[:page]).per(5)
	end

end