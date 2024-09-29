import { Box, Button, TextInput } from "@mantine/core";
import { useAddWorkspace } from "../Hooks/use-add-workspace-form";
import { useDeleteAllWorkspaces } from "../Hooks/use-delete-all-workspace-form";

export default function WorkspaceForm() {
    const { data, setData, submit, processing: addItemProcessing, errors } = useAddWorkspace();
    const { deleteAll, processing: deleteAllProcessing } = useDeleteAllWorkspaces();

    return (
        <Box component="form" onSubmit={submit}>
            <TextInput
                id="id"
                name="id"
                label="Workspace Name"
                value={data.name}
                onChange={(e) => setData("name", e.target.value)}
                error={errors.name}
                required
            />
            <Button type="submit" loading={addItemProcessing}>
                Add Workspace
            </Button>
            <Button color="red" onClick={deleteAll} loading={deleteAllProcessing} mt={16}>
                Delete All Workspaces
            </Button>
        </Box>
    );
}
