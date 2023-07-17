<!DOCTYPE html>
<html>
<head>
    <title>Diet Meal Suggestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        select {
            margin-top: 5px;
            padding: 5px;
        }

        input[type="submit"] {
            margin-top: 10px;
            padding: 8px 16px;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .meal-suggestion {
            margin-top: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Diet Meal Suggestion</h1>

    <form action="suggest_meal.php" method="POST">
        <label for="preference">Select your dietary preference:</label>
        <br>
        <select name="preference" id="preference">
            <option value="vegan">Vegan</option>
            <option value="vegetarian">Vegetarian</option>
            
            <option value="gluten_free">Gluten-Free</option>
            <option value="dairy_free">Dairy-Free</option>
            <option value="low_carb">Low Carb</option>
            <option value="low_calorie">Low Calorie</option>
            <option value="omnivore">Omnivore</option>
        </select>
        <br>
        <input type="submit" value="Get Meal Suggestion">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $preference = $_POST['preference'];
        $command = 'swipl -s diet_meal_suggestion.pl -g "findall(Meal, suggest_meal(\'' . $preference . '\', Meal), Meals), atomic_list_concat(Meals, \',\', Output), writeln(Output), halt."';
        $output = shell_exec($command);
        
        $meals = explode(",", trim($output));
        
        if (!empty($meals)) {
            echo '<div class="meal-suggestion">';
            echo '<h3>Based on your preference, we suggest the following meals:</h3>';
            echo '<table>';
            echo '<tr><th>Meal</th></tr>';
            foreach ($meals as $meal) {
                echo '<tr><td>' . trim($meal) . '</td></tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="meal-suggestion">';
            echo '<p>No meal suggestions found for your preference.</p>';
            echo '</div>';
        }
    }
    ?>
</body>
</html>
