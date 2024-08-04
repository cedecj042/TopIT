import os
import fitz  # PyMuPDF
from PIL import Image
import io

def extract_images_from_pdf(pdf_file):
    try:
        # Get the base name of the PDF file without the directory components and extension
        pdf_name = os.path.splitext(os.path.basename(pdf_file))[0]
        
        # Directory to save extracted images
        images_dir = os.path.join("images", pdf_name)
        
        # Create the directory if it doesn't exist
        os.makedirs(images_dir, exist_ok=True)
        
        # Open the PDF file
        pdf_document = fitz.open(pdf_file)
        
        images = []  # List to store image paths
        
        # Extract images from each page of the PDF
        for page_index in range(len(pdf_document)):
            page = pdf_document.load_page(page_index)
            image_list = page.get_images(full=True)
            
            for image_index, img in enumerate(image_list):
                xref = img[0]
                base_image = pdf_document.extract_image(xref)
                image_bytes = base_image["image"]
                image = Image.open(io.BytesIO(image_bytes))
                
                # Save the image
                image_filename = f"extracted_image_{page_index}_{image_index}.png"
                image_path = os.path.join(images_dir, image_filename)
                image.save(image_path)
                
                images.append(image_path)
        
        print(f"Image extraction complete for {pdf_file}. Images are saved in '{images_dir}'.")
        return images_dir, images

    except Exception as e:
        print(f"An error occurred: {str(e)}")
        return None, []

if __name__ == '__main__':
    import sys
    pdf_file = sys.argv[1]
    extract_images_from_pdf(pdf_file)
