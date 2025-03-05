
    <div id="Search"> 
        <form id="SearchForm" class="search-container" method="POST" onsubmit="Click(event)">
            <input class="search-bar" id="bar" name="search" type="text" placeholder="Rechercher un livre...">
            <button id="SearchButton" type="submit">
                <i class="fas fa-search"></i> <!-- Icône de recherche -->
            </button>
        </form>

    <div id="Resultat" class="book-grid"></div>

    </div>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php'; ?>
