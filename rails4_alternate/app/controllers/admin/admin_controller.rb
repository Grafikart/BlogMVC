class Admin::AdminController < ActionController::Base
	layout 'admin'
	before_filter :authenticate_user!

end