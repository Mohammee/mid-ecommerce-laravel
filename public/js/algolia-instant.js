// Replace with your own values


// The rest is the same.

const searchClient = algoliasearch( 'EIXN0TLS35',
    '693d7b798ac1f50f519905d346af57bc'
); // search only API key, not admin API key


const search = instantsearch({
    indexName: 'products',
    searchClient,
    routing: true,
    // urlSync: true
});


search.addWidgets([
    instantsearch.widgets.configure({
        hitsPerPage: 10,
    })
]);

search.addWidgets([
    instantsearch.widgets.stats({
        container: '#stats-container',
    })
]);

search.addWidgets([
    instantsearch.widgets.searchBox({
        container: '#search-box',
        placeholder: 'Search with algolia',
        // autofocus: false,
    })
]);

search.addWidgets([
    instantsearch.widgets.hits({
        container: '#hits',
        templates: {
            item:  function (item) {
               return  `
         <a href="${window.location.origin}/shop/${item.slug}"><div class="algolia-result">
              <img src="${window.location.origin}/storage/${item.image}"  />
              <div class="content">
                  <span class="hit-name">
                     ${item._highlightResult.name.value}
                  </span>
                  <div class="hit-details">
                  <em> ${item._highlightResult.details.value}</em>
                  </div>
              </div>
          </div></a>

          <div class="hit-price">\$${(item.price).toFixed(2)}</div>

     `},
        empty: `We didn't find any results for the search <em>"{{query}}"</em>`,

            }
    })
]);

// initialize RefinementList
search.addWidget(
    instantsearch.widgets.refinementList({
        container: '#refinement-list',
        attributeName: 'categories',
        attribute: 'categories',
        sortBy: ['name:asc']
    })
);

// initialize pagination
search.addWidget(
    instantsearch.widgets.pagination({
        container: '#pagination',
        maxPages: 10,
        // default is to scroll to 'body', here we disable this behavior
        scrollTo: false
    })
);

search.start();
