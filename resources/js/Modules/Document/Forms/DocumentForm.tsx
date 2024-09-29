import { Box, Button, TextInput } from "@mantine/core";
import { useAddDocument } from "../Hooks/use-add-document-form";
import { useDeleteAllDocuments } from "../Hooks/use-delete-all-document-form";

export default function FolderForm() {
    const { data, setData, submit, processing: addItemProcessing, errors } = useAddDocument();
    const { deleteAll, processing: deleteAllProcessing } = useDeleteAllDocuments();

    return (
        <Box component="form" onSubmit={submit}>
            <TextInput
                id="name"
                name="name"
                label="Document Name"
                value={data.name}
                onChange={(e) => setData("name", e.target.value)}
                error={errors.name}
                required
            />
            <Button type="submit" loading={addItemProcessing}>
                Add Document
            </Button>
            <Button color="red" onClick={deleteAll} loading={deleteAllProcessing} mt={16}>
                Delete All Documents
            </Button>
        </Box>
    );
}
