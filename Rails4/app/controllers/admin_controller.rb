class AdminController < ApplicationController
  before_filter :authenticate_user!
  def index
    @posts = Post.all.paginate(page: params[:page], per_page: 5)
  end
end
