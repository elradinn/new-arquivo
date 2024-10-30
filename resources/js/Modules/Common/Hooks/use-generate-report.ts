// resources/js/Modules/Common/Hooks/use-generate-report.ts
import axios from 'axios';

export default function useGenerateReport() {
    const generateReport = async (folderItemId: string) => {
        try {
            const response = await axios.post(route('report.generate'), {
                folder_item_id: folderItemId,
            });

            const { url, filename } = response.data;

            if (url) {
                // Create a temporary link to trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                console.error('No URL returned for the report.');
            }
        } catch (error: any) {
            console.error('Error generating report:', error.response?.data || error.message);
        }
    };

    return { generateReport };
}