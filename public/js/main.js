const articles = document.getElementById('delete_article');

articles.addEventListener('click', e => {
	if (confirm('vous etes sur que vous voulez supprimer cette article ?')) {
		const id = e.target.getAttribute('data-id');
		fetch(`/news/delete/${id}`, {
			method: 'DELETE'
		}).then(res => window.location.replace("/news/article"));
	}
});