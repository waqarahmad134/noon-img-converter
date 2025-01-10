import { Routes, Route, BrowserRouter } from "react-router-dom"
import React from "react"
import Home from "./pages/Home"
import ErrorPage from "./errors/error-page"
import { ToastContainer } from "react-toastify"
import { ChakraProvider } from "@chakra-ui/react"
import { HelmetProvider } from "react-helmet-async"
import Other from "./pages/Other"

function App() {
  return (
    <div>
      <ToastContainer />
      <HelmetProvider>
        <ChakraProvider>
          <BrowserRouter>
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/other" element={<Other />} />
              <Route path="*" element={<ErrorPage />} />
            </Routes>
          </BrowserRouter>
        </ChakraProvider>
      </HelmetProvider>
    </div>
  )
}

export default App
