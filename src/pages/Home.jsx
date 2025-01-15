import React, { useState, useRef } from "react"
import Header from "../components/Header"
import { ToastContainer, toast } from "react-toastify"
import "react-toastify/dist/ReactToastify.css"
import { use } from "react"

export default function Home() {
  const [inputValue, setInputValue] = useState("")
  const [outputValue, setOutputValue] = useState("")
  const [count, setCount] = useState(0)
  const [isProcessing, setIsProcessing] = useState(false)
  const [addLogo, setAddLogo] = useState(false)
  const [logo, setLogo] = useState(null)
  const [dimensions, setDimensions] = useState("660 X 900")
  const [logoPosition, setLogoPosition] = useState("bottom-right")
  const canvasRef = useRef(null)

  // const handleConvert = async () => {
  //   setIsProcessing(true)
  //   toast.info("Processing started...")

  //   const [canvasWidth, canvasHeight] = dimensions.split(" X ").map(Number)
  //   const lines = inputValue.split("\n")
  //   const urlPromises = lines.map(async (line) => {
  //     if (line.includes("ikea.com")) {
  //       try {
  //         const response = await fetch(
  //           "https://noon.bolly4u.cn/api/upload-from-url",
  //           {
  //             method: "POST",
  //             body: JSON.stringify({
  //               url: line.replace(/(\.[a-zA-Z]{3,4})(\?.*)?$/, "$1"),
  //             }),
  //             headers: { "Content-Type": "application/json" },
  //           }
  //         )
  //         const result = await response.json()
  //         console.log("🚀 ~ urlPromises ~ result:", result)
  //         if (result.success) {
  //           return result.url
  //         } else {
  //           toast.error("Failed to process IKEA image.")
  //           return null
  //         }
  //       } catch (error) {
  //         toast.error("Error processing IKEA image.")
  //         return null
  //       }
  //     }

  //     const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/)
  //     if (match) {
  //       return `${match[1]}US_${match[2]}` // Modify AC-specific URLs
  //     }

  //     return null // Skip invalid lines
  //   })

  //   const modifiedLines = (await Promise.all(urlPromises)).filter(Boolean)

  //   const newUrls = []
  //   for (const url of modifiedLines) {
  //     const processedUrl = await processImage(url, canvasWidth, canvasHeight)
  //     if (processedUrl) {
  //       newUrls.push(`https://noon.bolly4u.cn/api/${processedUrl}`)
  //     }
  //   }

  //   setOutputValue(newUrls.join("\n"))
  //   setCount(newUrls.length)
  //   setIsProcessing(false)
  //   toast.success("Processing completed!")
  // }

  const handleConvert = async () => {
    setIsProcessing(true)
    toast.info("Processing started...")

    const [canvasWidth, canvasHeight] = dimensions.split(" X ").map(Number)
    const lines = inputValue.split("\n")
    let isIkea
    console.log("🚀 ~ handleConvert ~ lines:", lines)
    if (lines?.[0].includes("ikea.com")) {
      isIkea = true
    }
    const urlPromises = lines.map(async (line) => {
      if (line.includes("ikea.com")) {
        try {
          const formData = new FormData()
          formData.append(
            "url",
            line.replace(/(\.[a-zA-Z]{3,4})(\?.*)?$/, "$1")
          )
          if (addLogo && logo) {
            formData.append("logo", logo)
          }

          const response = await fetch(
            "https://noon.bolly4u.cn/api/upload-from-url",
            {
              method: "POST",
              body: formData,
            }
          )
          const result = await response.json()
          if (result.success) {
            return result.url
          } else {
            toast.error("Failed to process IKEA image.")
            return null
          }
        } catch (error) {
          toast.error("Error processing IKEA image.")
          return null
        }
      } else {
        const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/)
        if (match) {
          return `${match[1]}US_${match[2]}` // Modify AC-specific URLs
        }
      }
      return null
    })

    const modifiedLines = (await Promise.all(urlPromises)).filter(Boolean)
    console.log("🚀 ~ handleConvert ~ modifiedLines:", modifiedLines)

    if (isIkea) {
      setOutputValue(modifiedLines.join("\n"))
    } else {
      const newUrls = []
      for (const url of modifiedLines) {
        const processedUrl = await processImage(url, canvasWidth, canvasHeight)
        if (processedUrl) {
          newUrls.push(`${processedUrl}`)
        }
      }
      setOutputValue(newUrls.join("\n"))
    }
    setCount(modifiedLines.length)
    setIsProcessing(false)
    toast.success("Processing completed!")
  }

  const handleCopy = () => {
    navigator.clipboard
      .writeText(outputValue)
      .then(() => toast.success("Copied to clipboard!"))
      .catch((err) => toast.error("Failed to copy"))
  }

  const processImage = async (imageUrl, canvasWidth, canvasHeight) => {
    return new Promise((resolve, reject) => {
      const canvas = canvasRef.current
      const ctx = canvas.getContext("2d")
      const img = new Image()
      img.crossOrigin = "anonymous"
      img.onload = async () => {
        canvas.width = canvasWidth
        canvas.height = canvasHeight
        ctx.clearRect(0, 0, canvas.width, canvas.height)
        ctx.fillStyle = "white"
        ctx.fillRect(0, 0, canvas.width, canvas.height)

        const scale = Math.min(
          canvas.width / img.width,
          canvas.height / img.height
        )

        const newWidth = img.width * scale
        const newHeight = img.height * scale
        const x = (canvas.width - newWidth) / 2
        const y = (canvas.height - newHeight) / 2
        ctx.drawImage(img, x, y, newWidth, newHeight)

        if (addLogo && logo) {
          const logoImg = new Image()
          logoImg.src = URL.createObjectURL(logo)
          logoImg.onload = () => {
            const logoSize = 100
            let logoX = 0
            let logoY = 0

            switch (logoPosition) {
              case "top-left":
                logoX = 10
                logoY = 10
                break
              case "top-right":
                logoX = canvas.width - logoSize - 10
                logoY = 10
                break
              case "bottom-left":
                logoX = 10
                logoY = canvas.height - logoSize - 10
                break
              case "bottom-right":
                logoX = canvas.width - logoSize - 10
                logoY = canvas.height - logoSize - 10
                break
              case "center":
                logoX = (canvas.width - logoSize) / 2
                logoY = (canvas.height - logoSize) / 2
                break
              default:
                break
            }

            ctx.drawImage(logoImg, logoX, logoY, logoSize, logoSize)

            canvas.toBlob(async (blob) => {
              const formData = new FormData()
              formData.append("image", blob, "processed-image.png")
              try {
                const response = await fetch(
                  "https://noon.bolly4u.cn/api/upload-file",
                  {
                    method: "POST",
                    body: formData,
                  }
                )
                const result = await response.json()
                if (result.success) {
                  resolve(result.url)
                } else {
                  toast.error("Image upload failed")
                  resolve(null)
                }
              } catch (error) {
                toast.error("Error uploading image")
                resolve(null)
              }
            }, "image/png")
          }
        } else {
          canvas.toBlob(async (blob) => {
            const formData = new FormData()
            formData.append("image", blob, "processed-image.png")
            try {
              const response = await fetch(
                "https://noon.bolly4u.cn/api/upload-file",
                {
                  method: "POST",
                  body: formData,
                }
              )
              const result = await response.json()
              console.log("Server response:", result) // Debugging line
              if (result.success) {
                resolve(result.url)
              } else {
                toast.error("Image upload failed")
                resolve(null)
              }
            } catch (error) {
              toast.error("Error uploading image")
              resolve(null)
            }
          }, "image/png")
        }
      }

      // Handle image loading error
      img.onerror = () => {
        toast.error("Failed to load image due to CORS issue or network error.")
        reject("Image loading failed")
      }

      img.src = imageUrl
    })
  }

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
                  <label className="text-sm font-medium">Dimensions</label>
                  <select
                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                    value={dimensions}
                    onChange={(e) => setDimensions(e.target.value)}
                  >
                    <option value="660 X 900">660 X 900</option>
                    <option value="800 X 1200">800 X 1200</option>
                  </select>
                </form>
              </div>
              <div className="flex items-center gap-3 mb-3">
                <input
                  type="checkbox"
                  checked={addLogo}
                  onChange={(e) => setAddLogo(e.target.checked)}
                />
                <label>Add Logo</label>
                <input
                  type="file"
                  accept="image/*"
                  onChange={(e) => setLogo(e.target.files[0])}
                />
                <select
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                  value={logoPosition}
                  onChange={(e) => setLogoPosition(e.target.value)}
                >
                  <option value="top-left">Top Left</option>
                  <option value="top-right">Top Right</option>
                  <option value="bottom-left">Bottom Left</option>
                  <option value="bottom-right">Bottom Right</option>
                  <option value="center">Center</option>
                </select>
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
                  disabled={isProcessing}
                  className={`${
                    isProcessing ? "bg-gray-500" : "bg-blue-700"
                  } text-white hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5`}
                  onClick={handleConvert}
                >
                  {isProcessing ? (
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
  )
}
