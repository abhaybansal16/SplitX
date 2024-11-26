<?php
function splitExpenses($pdo, $group_id) {
    // Query to fetch the relevant expense and group member data
    $query = "
        SELECT 
            e.eid,
            e.gid,
            e.amount,
            e.user_id AS payer_id
        FROM 
            expense1 e
        WHERE 
            e.gid = :group_id;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':group_id' => $group_id]);
    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $insertQuery = "
        INSERT INTO balance (uid, owed_to, amount)
        VALUES (:uid, :owed_to, :amount_owed);
    ";
    $insertStmt = $pdo->prepare($insertQuery);

    foreach ($expenses as $expense) {
        $payer_id = $expense['payer_id'];
        $amount = $expense['amount'];
        $group_id = $expense['gid'];

        // Fetch all group members except the payer
        $memberQuery = "SELECT user_id FROM group_mem WHERE gid = :gid";
        $memberStmt = $pdo->prepare($memberQuery);
        $memberStmt->execute([':gid' => $group_id]);
        $members = $memberStmt->fetchAll(PDO::FETCH_COLUMN);

        // Calculate the number of members excluding the payer
        $numMembers = count($members) - 1; // excluding the payer
        if ($numMembers > 0) {
            $splitAmount = $amount /($numMembers+1); // Split the amount equally among members

            foreach ($members as $member_id) {
                if ($member_id != $payer_id) { // Skip the payer
                    // Insert a new entry indicating that the member owes the payer
                    $insertStmt->execute([
                        ':uid' => $member_id,  // Member who owes
                        ':owed_to' => $payer_id,  // The payer to whom they owe
                        ':amount_owed' => $splitAmount
                    ]);
                    echo "balance added: User $member_id owes $payer_id amount $splitAmount"."<br>";
                }
            }
        }
    }
}

if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];
    splitExpenses($pdo, $group_id);
}
?>
