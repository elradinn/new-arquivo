import { Box, Button, TextInput } from "@mantine/core";
import { useAddFolder } from "../Hooks/use-add-folder-form";
import { useDeleteAllFolders } from "../Hooks/use-delete-all-folder-form";

export default function FolderForm() {
    const { data, setData, submit, processing: addItemProcessing, errors } = useAddFolder();
    const { deleteAll, processing: deleteAllProcessing } = useDeleteAllFolders();

    return (
        <Box component="form" onSubmit={submit}>
            <TextInput
                id="name"
                name="name"
                label="Folder Name"
                value={data.name}
                onChange={(e) => setData("name", e.target.value)}
                error={errors.name}
                required
            />
            <Button type="submit" loading={addItemProcessing}>
                Add Folder
            </Button>
            <Button color="red" onClick={deleteAll} loading={deleteAllProcessing} mt={16}>
                Delete All Folders
            </Button>
        </Box>
    );
}
