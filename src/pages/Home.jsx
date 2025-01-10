import React, { useState, useRef } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import Header from "../components/Header";

export default function Home() {
  const [inputValue, setInputValue] = useState("");
  const [outputValue, setOutputValue] = useState("");
  const [count, setCount] = useState(0);
  const [loading, setLoading] = useState(false);
  const [canvasDimensions, setCanvasDimensions] = useState({ width: 660, height: 900 });
  const canvasRef = useRef(null);

  const handleConvert = async () => {
    setLoading(true); // Start loading spinner
    const lines = inputValue.split("\n");

    const modifiedLines = lines
      .map((line) => {
        const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/);
        if (match) {
          return `${match[1]}US_${match[2]}`;
        }
        return null;
      })
      .filter(Boolean);

    const newUrls = [];

    for (const url of modifiedLines) {
      const processedUrl = await processImage(url);
      if (processedUrl) {
        newUrls.push(`https://noon.bolly4u.cn/${processedUrl}`);
      }
    }

    setOutputValue(newUrls.join("\n"));
    setCount(newUrls.length);
    setLoading(false); // Stop loading spinner
    toast.success("Conversion completed successfully!"); // Show success toaster
  };

  const handleCopy = () => {
    navigator.clipboard
      .writeText(outputValue)
      .then(() => toast.info("Copied to clipboard!"))
      .catch((err) => console.error("Failed to copy:", err));
  };

  const handleDimensionChange = (event) => {
    const [width, height] = event.target.value.split(" X ").map(Number);
    setCanvasDimensions({ width, height });
  };

  const processImage = async (imageUrl) => {
    return new Promise((resolve) => {
      const canvas = canvasRef.current;
      const ctx = canvas.getContext("2d");
      const img = new Image();

      img.crossOrigin = "anonymous";
      img.onload = async () => {
        canvas.width = canvasDimensions.width;
        canvas.height = canvasDimensions.height;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = "white";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
        const newWidth = img.width * scale;
        const newHeight = img.height * scale;
        const x = (canvas.width - newWidth) / 2;
        const y = (canvas.height - newHeight) / 2;

        ctx.drawImage(img, x, y, newWidth, newHeight);

        canvas.toBlob(async (blob) => {
          const formData = new FormData();
          formData.append("image", blob, "processed-image.png");

          try {
            const response = await fetch("https://noon.bolly4u.cn/upload.php", {
              method: "POST",
              body: formData,
            });
            const result = await response.json();
            if (result.success) {
              resolve(result.url);
            } else {
              console.error("Image upload failed:", result.error);
              resolve(null);
            }
          } catch (error) {
            console.error("Error uploading image:", error);
            resolve(null);
          }
        }, "image/png");
      };

      img.src = imageUrl;
    });
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
              <div className="flex justify-between items-center mb-3">
                <label className="text-[24px]">ADD LIST</label>
                <form className="max-w-sm flex items-center gap-3">
                  <label className="text-sm font-medium text-gray-900">Dimensions</label>
                  <select
                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    onChange={handleDimensionChange}
                  >
                    <option value="660 X 900">660 X 900</option>
                    <option value="800 X 1200">800 X 1200</option>
                  </select>
                </form>
              </div>
              <textarea
                id="message"
                rows="10"
                className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                placeholder={`Enter your numbers here`}
                value={inputValue}
                onChange={(e) => setInputValue(e.target.value)}
              ></textarea>
              <div className="mt-3 text-end">
                <button
                  type="button"
                  className={`text-white font-medium rounded-lg text-sm px-5 py-2.5 ${
                    loading
                      ? "bg-gray-400 cursor-not-allowed"
                      : "bg-blue-700 hover:bg-blue-800"
                  }`}
                  onClick={handleConvert}
                  disabled={loading}
                >
                  {loading ? (
                    <span className="flex items-center justify-center">
                      <svg
                        className="animate-spin h-5 w-5 mr-2 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                      >
                        <circle
                          className="opacity-25"
                          cx="12"
                          cy="12"
                          r="10"
                          stroke="currentColor"
                          strokeWidth="4"
                        ></circle>
                        <path
                          className="opacity-75"
                          fill="currentColor"
                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                      </svg>
                      Processing...
                    </span>
                  ) : (
                    "Convert"
                  )}
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
              className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
              placeholder="Valid numbers will appear here"
              value={outputValue}
            ></textarea>
            <div className="mt-3 text-end">
              <button
                type="button"
                className="text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5"
                onClick={handleCopy}
              >
                Copy
              </button>
            </div>
          </div>
        </div>
      </div>
      <div className="hidden">
        <canvas ref={canvasRef}></canvas>
      </div>
      <ToastContainer />
    </>
  );
}
