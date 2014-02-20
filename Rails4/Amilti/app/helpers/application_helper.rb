module ApplicationHelper
	def namespace
		if controller.class.name.split("::").first == "Admin"
			"Admin"
		end
	end

	def admin?	
		controller.class.name.split("::").first == "Admin"
	end

	def markdown(content)
		@markdown ||= Redcarpet::Markdown.new(Redcarpet::Render::HTML, autolink: true, space_after_headers: true, fenced_code_blocks: true)
		@markdown.render(content)
	end

	def time(date)
		Time.new - date
	end
end