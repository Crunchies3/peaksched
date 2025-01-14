let collections_of_predicted_values = [];
let months_ahead;

async function loadModel() {
    const model = await tf.loadLayersModel('./tfjs_model/model.json');
    console.log("Model loaded!");
    return model;
}

async function predictFutureDemand(model, startYear, startMonth, monthsAhead, scaledData) {
    // Log the scaled data to confirm the structure
    console.log('Scaled Data:', scaledData);

    // Find the starting index based on year and month
    const index = scaledData.findIndex((data) => data.year === startYear && data.month === startMonth) + 1;
    if (index === -1) {
        console.error("Start date not found in the data.");
        return;
    }

    console.log('Found starting index:', index);

    // Prepare the input sequence for prediction (previous 12 months)
    let pastData = scaledData.slice(index - 12, index);  // Previous 12 months
    console.log('Retrieved past data:', pastData);

    // Extract the scaled demand values and reshape them to match [12, 1]
    pastData = pastData.map(item => [item.scaledDemand]);  // Extract the scaled demand values
    pastData = pastData.reverse();  // Reverse to match [12, 1] shape for LSTM input

    // Check tensor shape before feeding into the model
    console.log('pastData shape before reshaping:', pastData);

    // Ensure pastData is reshaped into a tensor with shape [1, 12, 1]
    let reshapedData = tf.tensor([pastData]);  // This will create a tensor of shape [1, 12, 1]

    // Check tensor shape
    console.log('reshapedData shape:', reshapedData.shape);

    let predictions = [];

    // Predict demand for the next 'monthsAhead' months
    for (let i = 0; i < monthsAhead; i++) {
        // Ensure the input data is in shape [1, 12, 1] for LSTM
        const inputTensor = reshapedData;

        // Make the prediction
        const prediction = model.predict(inputTensor);

        // Denormalize the prediction
        const denormalizedPrediction = prediction.mul(max_value - min_value).add(min_value);
        let predictedDemand = denormalizedPrediction.dataSync()[0];

        // Normalize the predicted demand before appending it back
        const normalizedPrediction = (predictedDemand - min_value) / (max_value - min_value);

        // Push the denormalized prediction into predictions array
        predictions.push(predictedDemand);

        // Update the reshapedData: Slide the window and add the normalized prediction
        reshapedData = reshapedData.slice([0, 1, 0], [-1, 11, 1]);  // Keep the last 11 months
        reshapedData = tf.concat([reshapedData, tf.tensor([[[normalizedPrediction]]])], 1);  // Add the new normalized prediction
    }

    return predictions;
}
// Example scaled data (Replace this with your actual scaled data array)
const scaledData = [
    { year: 2024, month: 1, scaledDemand: 0.04 },
    { year: 2024, month: 2, scaledDemand: 0.12 },
    { year: 2024, month: 3, scaledDemand: 0.27 },
    { year: 2024, month: 4, scaledDemand: 0.33 },
    { year: 2024, month: 5, scaledDemand: 0.37 },
    { year: 2024, month: 6, scaledDemand: 0.80 },
    { year: 2024, month: 7, scaledDemand: 0.76 },
    { year: 2024, month: 8, scaledDemand: 0.97 },
    { year: 2024, month: 9, scaledDemand: 1.00 },
    { year: 2024, month: 10, scaledDemand: 0.55 },
    { year: 2024, month: 11, scaledDemand: 0.23 },
    { year: 2024, month: 12, scaledDemand: 0.14 }
];

// Example: Predict demand for the next 20 months (from January 2025 to August 2026)
//pde ra guro iparameterized ang 2024(year), 12(december or current month), 20(next months ahead)

async function regular_cleaning() {
    const model = await loadModel(); // Wait for the model to load
    const predictedFutureDemand = await predictFutureDemand(
        model, 2024, 12, months_ahead, scaledData
    );
    const predicted_values = predictedFutureDemand.map(demand => Math.round(demand));
    collections_of_predicted_values.push(predicted_values);
}


function detailed_cleaning() {
    const dataSubset = detailedCleaning.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}


function airbnb_cleaning() {
    const dataSubset = airBnBCleaning.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}


function move_out_in_cleaning() {
    const dataSubset = moveInOutCleaning.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function other_cleaning() {
    const dataSubset = otherCleaning.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function home_renovation() {
    const dataSubset = homeRenovation.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function drywall_repair() {
    const dataSubset = drywallRepair.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function painting_service() {
    const dataSubset = painting.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function pressure_washing() {
    const dataSubset = pressureWashing.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function cleaning_service() {
    const dataSubset = cleaningService.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}

function maintenance_service() {
    const dataSubset = maintenanceService.slice(0, months_ahead);
    collections_of_predicted_values.push(dataSubset);
    console.log(collections_of_predicted_values);
}






const min_value = 40;
const max_value = 180;

