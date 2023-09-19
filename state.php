<?php
include 'dbconn.php';

if (isset($_POST["country_value"])) {
    $country_value = $_POST["country_value"];
    if ($country_value == 'country') {
        $country_id = $_POST["country_id"];
        $result = mysqli_query($conn, "SELECT * FROM states where country_id = $country_id AND is_active = 1 ");
?>
        <!-- <datalist id="statename"> -->
        <option value="">Select State</option>
        <?php while ($row = mysqli_fetch_array($result)) : ?>
            <option value="<?php echo $row['id'] ?>"> <?php echo $row['name']; ?> </option>
        <?php endwhile; ?>
        <!-- echo "</datalist>"; -->
    <?php
    }
}

if (isset($_POST["state_value"])) {
    $state_value = $_POST["state_value"];
    if ($state_value == 'state') {
        $state_id = $_POST["state_id"];
        $result2 = mysqli_query($conn, "SELECT * FROM cities where state_id = $state_id AND is_active = 1 ");
    ?>
        <option value=""> Select City</option>
        <?php
        while ($row = mysqli_fetch_array($result2)) {
        ?>
            <option value="<?php echo $row["id"]; ?>"><?php echo  strtoupper($row["name"]); ?></option>
<?php
        }
    }
}

?>