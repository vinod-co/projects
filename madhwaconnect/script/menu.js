$(function() {
	$('#menu')
		.EZMenu([
			{
				name: "Just for me",
				options: [
					{name: "Notifications", url: "#"},
					{name: "Inbox", url: "#"},
					{name: "My Profile", url: "#"},
					{name: "Settings", url: "#"},
					{name: "Logout", url: "#"},
				]

			},
			{ "name" : "Menu List A", "options" : [
				{ "name" : "Item 1A", "url" : "http://item1A.domain.com" },
				{ "name" : "Item 2A", "url" : "http://item2A.domain.com" },
				{ "name" : "Menu List B", "options" : [
					{ "name" : "Item 1B", "url" : "http://item1B.domain.com" },
					{ "name" : "Item 2B", "url" : "http://item2B.domain.com",
						"classname" : "custom_link" }
				]}
			]}
		]);
});
