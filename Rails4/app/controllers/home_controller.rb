class HomeController < ApplicationController
  def index
    @posts = Post.order('created_at desc').paginate(page: params[:page], per_page: 2)
  end
end
