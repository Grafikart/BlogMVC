class Comment < ActiveRecord::Base
  include Gravtastic
  gravtastic :mail

  belongs_to :post
  validates :username, presence: true
  validates :mail, presence: true, format: {with: /\A([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})\Z/i}
  validates :content, presence: true
end
