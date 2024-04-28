document.addEventListener('DOMContentLoaded', function () {
    var taskDetailsPopup = document.getElementById('taskDetailsPopup');
    var closePopupBtn = document.getElementById('closePopup');
    var submitDeleteBtn = document.getElementById('submitDelete');
    var submitCommentBtn = document.getElementById('submitComment');
    var commentInput = document.getElementById('comment');
    var comments;

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'dayGridMonth',
        events: 'tasks.php',
        selectable: true,
        selectHelper: true,
        select: function (info) {
            var startDate = info.startStr + ' 00:00:00';
            var endDate = info.endStr + ' 00:00:00';
            selectDates(startDate, endDate);
        },
        editable: true,
        eventClick: function (info) {
            showTaskDetailsPopup(info.event);
            submitDeleteBtn.dataset.id = info.event.id;
            taskId = submitDeleteBtn.dataset.id;
        },

        eventDrop: function (event, delta) {
            var start = event.event.start.toISOString();
            var end = event.event.end.toISOString();
            $.ajax({
                url: 'update_tasks.php',
                data: {
                    title: event.event.title,
                    start_date: start,
                    end_date: end,
                    id: event.event.id
                },
                type: "POST",
            });
        },
        eventResize: function (event) {
            var start = event.event.start.toISOString();
            var end = event.event.end.toISOString();
            $.ajax({
                url: 'update_tasks.php',
                data: {
                    title: event.event.title,
                    start_date: start,
                    end_date: end,
                    id: event.event.id
                },
                type: "POST",
            });
        },
        locale: 'de',
        timeZone: 'Europe/Berlin'
    });

    function deleteTask(taskId) {
        $.ajax({
            url: 'delete_tasks.php', // Replace with the actual URL of your server-side script
            data: { id: taskId },
            type: 'POST',
            success: function (response) {
                taskDetailsPopup.style.display = 'none';
                calendar.refetchEvents(); // Assuming you want to refresh the calendar after deletion
            },
            error: function (error) {
                // Handle the error response
                alert('Error deleting task');
                console.error(error);
            }
        });
    }

    function addComment(taskId, commentText) {
        $.ajax({
            url: 'add_comment.php', // Replace with the actual URL of your server-side script
            data: {
                task_id: taskId,
                comment: commentText
            },
            type: 'POST',
            success: function (response) {
                // Handle the success response, e.g., refresh comments or update the UI
                console.log('Comment added successfully');
                fetchComments(taskId);
            },
            error: function (error) {
                // Handle the error response
                console.error('Error adding comment');
            }
        });
    }

    function fetchComments(taskId) {
        $.ajax({
            url: 'comments.php',
            data: {
                task_id: taskId
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                // Handle the success response, e.g., update the UI with comments
                if (response.success) {
                    comments = (response.comments);  // Corrected variable name
                    displayComments(response.comments);
                } else {
                    console.error('Error fetching comments');
                }
            },
            error: function (error) {
                // Handle the error response
                console.error('Error fetching comments');
            }
        });
    }

    submitCommentBtn.addEventListener('click', function () {
        var taskId = submitDeleteBtn.dataset.id;
        var commentText = commentInput.value;
        commentInput.value = '';

        if (commentText !== '') {
            addComment(taskId, commentText);
            commentInput.innerHTML = '';
        } else {
            console.warn('Comment cannot be empty');
        }
    });



    function displayComments(comments) {
        var commentsContainer = document.getElementById('commentsContainer');
        commentsContainer.innerHTML = '';
        console.log(comments);

        if (comments && comments.length > 0) {
            var commentsList = document.createElement('div');

            comments.forEach(function (comment) {
                var commentItem = document.createElement('p');
                commentItem.innerHTML = "<span style='color: white; margin: 0px!important;'>▷ " + comment['username'] + ", " + comment['created_at'] + '</span><br>' + comment['comment_text'];
                commentItem.style.color = comment['user_color'];

                commentsList.appendChild(commentItem);
            });
            commentsContainer.appendChild(commentsList);
        }
    }

    closePopupBtn.addEventListener('click', function () {
        hideTaskDetailsPopup();
    });

    submitDeleteBtn.addEventListener('click', function () {
        var id = submitDeleteBtn.dataset.id;
        deleteTask(id);
    });


    function selectDates(startDate, endDate) {
        var taskForm = document.getElementById('taskForm');
        var startDateInput = document.getElementById('startDateTime');
        var endDateInput = document.getElementById('endDateTime');
        startDateInput.value = startDate;
        endDateInput.value = endDate;
        taskForm.style.display = 'flex';
    }

    function hideTaskDetailsPopup() {
        taskDetailsPopup.style.display = 'none';
    }

    function showTaskDetailsPopup(event) {
        var options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZone: 'Europe/Berlin',
        };

        // Populate popup content with task details
        document.getElementById('taskPopupUser').textContent = 'Erstellt von ' + event.extendedProps.username;
        document.getElementById('taskPopupUser').style.color = event.extendedProps.color_user;
        document.getElementById('taskPopupUser').style.fontWeight = '500';

        document.getElementById('popupTitle').textContent = event.title;

        document.getElementById('popupDescription').textContent = event.extendedProps.description || '';

        // Manually adjust the start and end times to match the desired time zone
        var adjustedStart = new Date(event.start);
        adjustedStart.setHours(adjustedStart.getHours() + adjustedStart.getTimezoneOffset() / 60);

        var adjustedEnd = new Date(event.end);
        adjustedEnd.setHours(adjustedEnd.getHours() + adjustedEnd.getTimezoneOffset() / 60);

        document.getElementById('popupStart').textContent = adjustedStart.toLocaleString('de-DE', options) + ' Uhr';
        document.getElementById('popupEnd').textContent = adjustedEnd.toLocaleString('de-DE', options) + ' Uhr';

        taskDetailsPopup.style.display = 'flex';
        fetchComments(event.id);
    }

    calendar.render();
});
