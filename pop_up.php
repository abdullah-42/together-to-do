<div class="popup-container" id="taskDetailsPopup">
    <div>
        <div class="task-delete">
            <p id='taskPopupUser'></p>
            <button type="button" id="submitDelete" class="red-btn delete-btn">Löschen</button>
        </div>
        <h2 id="popupTitle">Titel:</h2>
        <div class="pop-up-flex">
            <div class="taskDetail-container">
                <label>Details:</label>
                <p id="popupDescription"></p>
                <label>Start:</label>
                <p id="popupStart"></p>
                <label>Ende:</label>
                <p id="popupEnd"></p>
            </div>
            <div id="commentsContainer">
            </div>
        </div>
        <form id="commentForm">
            <label>Kommentar:</label>
            <input sytle="background-color: var(--purple-dark)" id="comment" name="comment" rows="4" cols="50"></input>
            <div class="pop-up-btn-container">
                <button type="button" id="closePopup" class="red-btn">schließen</button>
                <button type="button" id="submitComment" class="green-btn">abschicken</button>
            </div>
        </form>
    </div>

</div>