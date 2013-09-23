class Post < ActiveRecord::Base
  extend FriendlyId
  friendly_id :name, use: :slugged

  belongs_to :category
  belongs_to :user

  validates :name, presence: true
  validates :content, presence: true
end
