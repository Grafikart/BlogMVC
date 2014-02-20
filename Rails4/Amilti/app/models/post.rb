class Post < ActiveRecord::Base
	extend FriendlyId
	before_save :to_slug
	friendly_id :name, use: :slugged

	validates :name, :content, presence: true
	has_many :comments
	belongs_to :category, :counter_cache => true
	belongs_to :user

	def should_generate_new_friendly_id?
		slug.blank?
	end

	def to_slug
		unless self.slug.blank?
			 self.slug = self.slug.downcase.gsub(" ", "-")
		end
	end
end