import './bootstrap';
console.log('app.js loaded');

if (window.Echo) {
	window.Echo.channel('articles')
		.listen('.article.created', (e) => {
			console.log('received', e);
			alert('Новая статья: ' + e.title);
		});
} else {
	console.log('Echo is undefined');
}