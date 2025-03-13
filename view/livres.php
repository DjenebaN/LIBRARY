   
    <div class="mainContent">

        <div class="Resultat">

            <div class="Search">
                <form class="search" id="SearchForm" method="POST" onsubmit="Click(event)">
                    <input type="text" class="search__input" id="bar" name="text" placeholder="Recherchez un livre">
                    <button class="search__button" type="submit">
                        <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                            <g>
                                <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                            </g>
                        </svg>
                    </button>
                </form>

                <div class="imagesSearch">
                    <ul>
                    <li> <a href="index.php?page=livres"><div>Livres</div></a> </li>
                    <li> <a href="index.php?page=prets&Id_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur'])?>"> <div>Compte</div></a> </li>
                    </ul>
                </div>
            </div>

            <div id="Livres">
                <div class="avantSearch">
                    <h2> Voici une liste de ressources utiles</h2>
                    <div class="ressourcesBloc">
                        <div class="ressources">
                            <ul>
                                <li> <a href="https://annas-archive.org"> Les archives d'Anna</a></li>
                                <li> <a href="https://books.google.fr"> Google Books</a></li>
                            </ul>
                        </div>
                        <div class="imgRessources"><img src="view/style/book.jpg" alt="Girl in a jacket"></div>
                    </div>
                    <div class="livresJour">
                        <ul>
                            <li class ="livreJ"><img src="view/style/hp1.jpg" alt="Girl in a jacket"></li>
                            <li class ="livreJ"><img src="view/style/hp2.jpg" alt="Girl in a jacket"></li>
                            <li class ="livreJ"><img src="view/style/hp3.jpg" alt="Girl in a jacket"></li>
                            <li class ="livreJ"><img src="view/style/hp4.jpg" alt="Girl in a jacket"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="newDetailsSection"></div>
    </div>

<script>
    const Id_Lecteur = <?php echo json_encode($_SESSION['Id_Lecteur']); ?>;
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php';
?>