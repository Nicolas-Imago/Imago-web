
<section id = "information">

    <div id = "information_header">
        <a class = "logo_image">
            <img class = "logo_image" <?php display_image("logo") ?> alalt="note" t>
        </a>
        <span id = "title">
					<a class = "name" <?php display_link("admin") ?> > <?php ECHO $content["name"] ?> </a>
					<a class = "author"> <?php display_author() ?> </a>
				</span>
        <?php display_image("author") ?>
    </div>


    <div class = "description">
        <a class = "description"> <?php ECHO $content["description"] ?> </a>
        <!-- <a class = "more_info"> En savoir plus</a> -->
    </div>

    <div class = "date">
        <a class = "title"> Année : </a>
        <a class = "year"> <?php ECHO $content["date"] ?> </a>
    </div>

    <div class = "duration">
        <a class = "title"> Durée : </a>
        <a class = "duration"> <?php ECHO $content["duration"] . " minutes" ?> </a>
    </div>

    <div class = "category">
        <a  class = "title"> Thématique : </a>
        <a class = "category"> <?php ECHO $content["category"] ?> </a>
    </div>

    <div class = "info">
        <a class = "title"> <?php ECHO $info_title ?> </a>
        <a class = "data"> <?php ECHO $info_data ?> </a>
    </div>


    <div id = "note_1">
        <div class = "note_title">
            <a class = "title"> Accessibilité </a>
            <a> au grand public : </a>
        </div>
        <div class = "note">
            <img id = "note_1_1" class = "note_image" <?php display_note(1, "1") ?> alt="note">
            <img id = "note_1_2" class = "note_image" <?php display_note(2, "1") ?> alt="note">
            <img id = "note_1_3" class = "note_image" <?php display_note(3, "1") ?> alt="note">
            <img id = "note_1_4" class = "note_image" <?php display_note(4, "1") ?> alt="note">
            <img id = "note_1_5" class = "note_image" <?php display_note(5, "1") ?> alt="note">
        </div>
    </div>

    <div id = "note_2">
        <div class = "note_title">
            <a class = "title"> Analyse </a>
            <a> des modèles dominants : </a>
        </div>
        <div class = "note">
            <img id = "note_2_1" class = "note_image" <?php display_note(1, "2") ?> alt="note">
            <img id = "note_2_2" class = "note_image" <?php display_note(2, "2") ?> alt="note">
            <img id = "note_2_3" class = "note_image" <?php display_note(3, "2") ?> alt="note">
            <img id = "note_2_4" class = "note_image" <?php display_note(4, "2") ?> alt="note">
            <img id = "note_2_5" class = "note_image" <?php display_note(5, "2") ?> alt="note">
        </div>
        alt="note">
        <div id = "note_3">
            <div class = "note_title">
                <a class = "title"> Proposition </a>
                <a> de modèles alternatifs : </a>
            </div>
            <div class = "note">
                <img id = "note_3_1" class = "note_image" <?php display_note(1, "3") ?> alt="note">
                <img id = "note_3_2" class = "note_image" <?php display_note(2, "3") ?> alt="note">
                <img id = "note_3_3" class = "note_image" <?php display_note(3, "3") ?> alt="note">
                <img id = "note_3_4" class = "note_image" <?php display_note(4, "3") ?> alt="note">
                <img id = "note_3_5" class = "note_image" <?php display_note(5, "3") ?> alt="note">
            </div>

            <!-- <a class = "set_note"> envoyez vos notes </a> -->
            <!-- <a class = "more_note"> plus de notes</a> -->
        </div>

</section>
