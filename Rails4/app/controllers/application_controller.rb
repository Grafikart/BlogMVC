# encoding: utf-8
class ApplicationController < ActionController::Base
  # Prevent CSRF attacks by raising an exception.
  # For APIs, you may want to use :null_session instead.
  protect_from_forgery with: :exception
  helper_method "user_signed_in?", "current_user"

  def authenticate_user!
    unless user_signed_in?
      session[:next_url] = ( request.url || "/" )
      redirect_to login_path
      flash[:erreur] = "Authentifiez vous avant d'accéder à cette page."
    end
  end

  def current_user
    session[:user]
  end

  def user_signed_in?
    session[:user] != nil
  end
end
