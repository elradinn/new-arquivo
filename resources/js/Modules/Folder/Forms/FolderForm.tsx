import { Button, Flex, Modal, Stack, Text, TextInput } from "@mantine/core";
import { useAddFolder } from "../Hooks/use-add-folder-form";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface IProps {
    isOpened: boolean;
    close: () => void;
    itemParent?: ItemParentResourceData;
}

const CreateFolderForm: React.FC<IProps> = ({ isOpened, close, itemParent }) => {
    const { data, setData, submit, processing, errors } = useAddFolder({ itemParent, close });
    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Create Folder
                </Text>
            }
            size={550}
        >
            <form onSubmit={submit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        placeholder="Folder Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default CreateFolderForm;