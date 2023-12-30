<?php
session_start();
require "connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
} else {
    $comment = $_POST["comment"];
    $user_id = $_SESSION["user_id"];
    $gameID = $_POST["gameID"];

    $sql = "INSERT INTO `comments` (`g_id`, `u_id`, `comment`, `date_time`) VALUES ('$gameID', '$user_id', '$comment', current_timestamp())";
    $result = mysqli_query($con, $sql);
    if ($result) {
        http_response_code(200);
        $sql = "SELECT *,comments.id as c_id FROM comments JOIN user ON comments.u_id = user.id WHERE g_id = $gameID AND u_id = $user_id ORDER BY date_time DESC; ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        echo '<div id="comment-' .
            $row["c_id"] .
            '" class="comment" >
            <div class="comment-user-info"><img class="FriendProfileIcon" src="images/userPFP/' . $row['pfp'] . '"><div class="comment-user-inner-info">
                        <h2 class="comment_username">' .
            $row["username"] .
            '</h2>
                        <h5 class="comment_date">' .
            date("d/m/Y", strtotime($row["date_time"])) .
            " at " .
            date("h:i A", strtotime($row["date_time"])) .
            '</h5>
                        <p class="comment_text">' .
            $comment .
            '</p></div></div>
                        <div class="comment_likes" >
                            <div  class="comment_like">
                                <svg id="like-' .
            $row["c_id"] .
            '" data-comment-id="' .
            $row["c_id"] .
            '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                </svg>
                                <p id="like-count-' .
            $row["c_id"] .
            '" class="comment_like_text">0</p>
                                </div>
                                <div  class="comment_dislike" >
                                <svg id="dislike-' .
            $row["c_id"] .
            '" data-comment-id="' .
            $row["c_id"] .
            '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down" " viewBox="0 0 16 16">
                                <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                                </svg>
                                <p id="dislike-count-' .
            $row["c_id"] .
            '" class="comment_dislike_text">0</p>
                            </div>
                            <div class="comment_edit">
                                    <svg style="position:relative; top:-25px" data-comment-id="' .
            $row["c_id"] .
            '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi editComment bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </div>
                                <div class="comment_delete" >
                                    <svg style="position:relative; top:-25px" data-comment-id="' .
            $row["c_id"] .
            '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi deleteComment bi-trash3" viewBox="0 0 16 16">
                                        <path data-comment-id="' .
            $row["c_id"] .
            '" d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </div>
                        </div>
                        <hr>
                    </div>
                            ';
    } else {
        http_response_code(400);
    }
}
