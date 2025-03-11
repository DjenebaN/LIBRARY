 <?php 

if (isset($_SESSION['message'])) {
    echo "<p style='color:red;'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']); // Supprime le message après l'affichage
}  

?>
    
    <div class="mainContent">

        <div class="Resultat">

            <div class="Search">
                <form id="SearchForm" method="POST" onsubmit="Click(event)">
                    <input placeholder="Search.." id="bar" name="text" type="text">
                    <button id="SearchButton" type="submit">
                        <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                          </svg>
                        </i>
                    </button>
                </form>
                <div class="imagesSearch">aaa</div>
            </div>

            <div class="resultTitre">aaa</div>

            <div id="Livres"></div>
            <div id="newDetailsSection"></div>

        </div>
    </div>

<script>
    const Id_Lecteur = <?php echo json_encode($_SESSION['Id_Lecteur']); ?>;
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php';
?>