# encoding: utf-8
class UserController < ApplicationController
  layout "admin"

  def login
    if params[:username]
      username, password = params[:username], params[:password]
      @user = User.authenticate username, password

      if @user
        session[:user] = @user
        flash[:notice] = "Connecté"

        redirect_to (session[:next_url] || admin_path)
      else
        flash[:error] = "Nom d'utilisateur ou mot de passe incorrect"
      end
    end
  end

  def logout
    session[:user] = nil
    redirect_to root_path
    flash[:notice] = "déconnecté"
  end
end
