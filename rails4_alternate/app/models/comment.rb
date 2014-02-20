class Comment < ActiveRecord::Base
	validates :mail, email_format: { message: "doesn't look like an email address" }
	validates :username, :content, presence: true
	belongs_to :post
end