import React, { useState } from "react";
import Header from "../components/Header";

export default function Home() {
  const [inputValue, setInputValue] = useState("");
  const [outputValue, setOutputValue] = useState("");
  const [count, setCount] = useState(0);

  const handleConvert = () => {
    // Split the input into lines
    const lines = inputValue.split("\n");

    // Process each line to modify the URL
    const modifiedLines = lines.map((line) => {
      const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/);
      if (match) {
        return `${match[1]}SR660,900_${match[2]}`;
      }
      return null; // Skip invalid lines
    }).filter(Boolean); // Remove null values

    // Update state with the result
    setOutputValue(modifiedLines.join("\n"));
    setCount(modifiedLines.length);
  };

  const handleCopy = () => {
    navigator.clipboard
      .writeText(outputValue)
      .then(() => alert("Copied to clipboard!"))
      .catch((err) => console.error("Failed to copy:", err));
  };

  return (
    <>
      <Header />
      <div className="font-poppins w-11/12 m-auto max-w-[1400px] mx-auto py-10">
        <h1 className="text-4xl mb-5">Converter :</h1>
        <div className="grid md:grid-cols-2 gap-10">
          {/* Left Side - Input */}
          <div>
            <div className="w-full lg:w-auto">
              <label className="text-[24px] mb-3">ADD LIST</label>
              <textarea
                id="message"
                rows="10"
                className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder={`Enter your numbers here`}
                value={inputValue}
                onChange={(e) => setInputValue(e.target.value)}
              ></textarea>
              <div className="mt-3 text-end">
                <button
                  type="button"
                  className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                  onClick={handleConvert}
                >
                  Convert
                </button>
              </div>
            </div>
          </div>

          {/* Right Side - Output */}
          <div>
            <label className="text-[24px] mb-3">YOUR LIST ({count})</label>
            <textarea
              id="message"
              rows="10"
              cols="30"
              disabled
              className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Valid numbers will appear here"
              value={outputValue}
            ></textarea>
            <div className="mt-3 text-end">
              <button
                type="button"
                className="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"
                onClick={handleCopy}
              >
                Copy
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
