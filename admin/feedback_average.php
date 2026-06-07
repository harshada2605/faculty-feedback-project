

<!-- Faculty Selection Form -->
<form method="post">
    <table class="table table-hover">
        <tr>
            <th>Select Faculty</th>
            <td>
                <select name="faculty" class="form-control">
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM faculty");
                    while ($r = mysqli_fetch_array($sql)) {
                        echo "<option value='" . $r['email'] . "'>" . $r['Name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input name="sub" type="submit" value="Check Average" class="btn btn-success"/></td>
        </tr>
    </table>
</form>
<?php


if (isset($_POST['sub'])) {
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']); // Prevent SQL Injection

    // Count total feedback entries for selected faculty
    $result = mysqli_query($conn, "SELECT * FROM feedback WHERE faculty_id='$faculty'");
    $totalResponses = mysqli_num_rows($result);

    echo "<h4>Total Student Attempts: " . $totalResponses . "</h4>";

    // Initialize rating counters
    $strongly_agree = $agree = $neutral = $disagree = $strongly_disagree = 0;
    $strongly_agree1 = $agree1 = $neutral1 = $disagree1 = $strongly_disagree1 = 0;
    $totalScore = 0;

    // Process feedback data
    while ($res = mysqli_fetch_array($result)) {
        // Question 1 Ratings
        switch (intval($res[3])) {
            case 5: $strongly_agree++; break;
            case 4: $agree++; break;
            case 3: $neutral++; break;
            case 2: $disagree++; break;
            case 1: $strongly_disagree++; break;
        }

        // Question 2 Ratings
        switch (intval($res[4])) {
            case 5: $strongly_agree1++; break;
            case 4: $agree1++; break;
            case 3: $neutral1++; break;
            case 2: $disagree1++; break;
            case 1: $strongly_disagree1++; break;
        }

        // Calculate total feedback score (ensuring all values are integers)
        for ($i = 3; $i <= 15; $i++) {
            $totalScore += intval($res[$i]);  // Convert each value to integer
        }
    }

    // Display total counts
    $totalStronglyAgree = $strongly_agree + $strongly_agree1;
    echo "<h4>Total Strongly Agree Responses: $totalStronglyAgree</h4>";
    echo "<h4>Total Score: " . $totalScore . "</h4>";
}
?>
<hr style="border:1px solid red"/>
